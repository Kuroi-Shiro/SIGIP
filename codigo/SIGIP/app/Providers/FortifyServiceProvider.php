<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Usuario;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Redirección tras el login según el rol
        $this->app->singleton(LoginResponse::class, fn () => new class implements LoginResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    return response()->json(['two_factor' => false]);
                }

                $destino = $request->user()?->rol === 'Administrador'
                    ? '/dashboard'
                    : '/categorias';

                return redirect()->intended($destino);
            }
        });

        // Al cerrar sesión, volver al login
        $this->app->singleton(LogoutResponse::class, fn () => new class implements LogoutResponse {
            public function toResponse($request)
            {
                return $request->wantsJson()
                    ? response()->noContent()
                    : redirect('/login');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        Fortify::loginView(fn () => view('auth.login'));

        // Solo usuarios activos (no archivados) pueden iniciar sesión
        Fortify::authenticateUsing(function (Request $request) {
            $usuario = Usuario::where('email', $request->input(Fortify::username()))
                ->where('activo', true)
                ->first();

            if ($usuario && Hash::check($request->input('password'), $usuario->password)) {
                return $usuario;
            }

            return null;
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip()
            );
        });
    }
}