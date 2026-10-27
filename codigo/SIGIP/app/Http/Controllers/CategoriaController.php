<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarCategoriaRequest;
use App\Http\Requests\GuardarCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::withCount('productos')
            ->where('activo', true)
            ->orderBy('nombre')
            ->paginate(10);


        $archivadas = Categoria::withCount('productos')
            ->where('activo', false)
            ->orderBy('nombre')
            ->get();

        return view('categorias.index', compact('categorias', 'archivadas'));
    }


    public function create(): View
    {
        return view('categorias.create');

    }


    public function store(GuardarCategoriaRequest $request): RedirectResponse
    {
        try {
            Categoria::create([...$request->validated(), 'activo' => true]);
        } catch (Throwable $e) {
            return $this->falloAlGuardar($e, 'registrar');
        }

        return redirect()->route('categorias.index')->with('exito', 'Categoría registrada.');
    }
    
    public function show(Categoria $categoria): View
    {
        $categoria->load('productos');

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));

    }

    public function update(ActualizarCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        try {
            $categoria->update($request->validated());
        } catch (Throwable $e) {
            return $this->falloAlGuardar($e, 'actualizar');
        }

        return redirect()->route('categorias.index')->with('exito', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        try {
            $categoria->delete();
        } catch (Throwable $e) {
            return $this->falloAlGuardar($e, 'eliminar');
        }

        return redirect()->route('categorias.index')->with('exito', 'Categoría eliminada.');
    }



    public function archivar(Categoria $categoria): RedirectResponse
    {
        if (!$categoria->activo) {
            return redirect()
                ->route('categorias.index')
                ->with('error', 'La categoría ya se encuentra archivada.');
        }

        try{
            $categoria->update(['activo' => false,]);
        } catch (Throwable $e){
            return $this->falloAlGuardar($e, 'archivar');
        }

        return redirect()
            ->route('categorias.index')
            ->with('exito', 'Categoría archivada.');
    }

    public function restaurar(Categoria $categoria): RedirectResponse
    {
        if ($categoria->activo) {
            return redirect()
                ->route('categorias.index')
                ->with('error', 'La categoría ya se encuentra activa.');
        }

        try{
            $categoria->update(['activo' => true]);
        } catch (Throwable $e){
            return $this->falloAlGuardar($e, 'restaurar');
        }

        return redirect()
            ->route('categorias.index')
            ->with('exito', 'Categoría restaurada.');
    }

    private function falloAlGuardar(Throwable $e, string $accion): RedirectResponse
    {
        Log::error("Categorías: error al {$accion}", ['mensaje' => $e->getMessage()]);

        // SQLSTATE 23000 = violación de integridad (p. ej. nombre duplicado por doble envío)
        $mensaje = ($e instanceof QueryException && $e->getCode() === '23000')
            ? 'No se pudo completar la operación porque entra en conflicto con otros datos (por ejemplo, un nombre ya registrado).'
            : "Ocurrió un error al {$accion} la categoría. Intenta de nuevo.";

        return back()->withInput()->with('error', $mensaje);
    }
}