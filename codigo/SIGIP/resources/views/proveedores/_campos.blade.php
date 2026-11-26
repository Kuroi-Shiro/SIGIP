{{--
    Parcial: campos de un proveedor (compartido por create y edit).
    Recibe: $productos (catálogo activo) y $proveedor (opcional; null al crear).
--}}
@php
    $proveedor = $proveedor ?? null;
    $input = fn ($campo) => 'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary '
        . ($errors->has($campo) ? 'border-red-500 bg-red-50' : 'border-line');
    $seleccionados = collect(old('producto_ids', $proveedor?->productos->pluck('id')->all() ?? []))
        ->map(fn ($id) => (int) $id)
        ->all();
    $hayErrorProductos = $errors->has('producto_ids') || $errors->has('producto_ids.*');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div class="md:col-span-2">
        <label for="nombre" class="block text-sm font-medium text-ink mb-1">Nombre *</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $proveedor?->nombre) }}"
               placeholder="Ej. Maderas del Norte S.A." class="{{ $input('nombre') }}">
        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="telefono" class="block text-sm font-medium text-ink mb-1">Teléfono *</label>
        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $proveedor?->telefono) }}"
               placeholder="Ej. 614 123 4567" class="{{ $input('telefono') }}">
        @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-ink mb-1">Correo electrónico *</label>
        <input type="email" id="email" name="email" value="{{ old('email', $proveedor?->email) }}"
               placeholder="contacto@proveedor.com" class="{{ $input('email') }}">
        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>


    <div class="md:col-span-2">
        <label for="direccion" class="block text-sm font-medium text-ink mb-1">Dirección *</label>
        <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $proveedor?->direccion) }}"
               placeholder="Calle, número, colonia, ciudad" class="{{ $input('direccion') }}">
        @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-ink mb-1">Productos que suministra *</label>
    <p class="text-xs text-muted mb-2">Selecciona al menos un producto.</p>

    <div @class([
        'grid grid-cols-1 sm:grid-cols-2 gap-1 max-h-64 overflow-y-auto border rounded-lg p-2',
        'border-red-500 bg-red-50' => $hayErrorProductos,
        'border-line' => !$hayErrorProductos,
    ])>
        @forelse($productos as $producto)
            <label for="producto_{{ $producto->id }}"
                   class="flex items-center gap-2 px-2 py-1.5 rounded-md text-sm cursor-pointer hover:bg-surface transition-colors">
                <input type="checkbox" id="producto_{{ $producto->id }}" name="producto_ids[]" value="{{ $producto->id }}"
                       @checked(in_array($producto->id, $seleccionados, true)) class="rounded border-line">
                <span class="font-mono text-xs text-muted">{{ $producto->codigo }}</span>
                <span class="text-ink">{{ $producto->nombre }}</span>
            </label>
        @empty
            <p class="text-sm text-muted p-2">No hay productos activos registrados.</p>
        @endforelse
    </div>

    @error('producto_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    @foreach($errors->get('producto_ids.*') as $mensajes)
        @foreach($mensajes as $mensaje)
            <p class="text-red-500 text-xs mt-1">{{ $mensaje }}</p>
        @endforeach
    @endforeach
</div>
