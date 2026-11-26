{{--
    Parcial: campos de un movimiento (compartido por create y edit).
    Recibe: $productos (catálogo activo) y $movimiento (opcional; null al crear).
--}}
@php
    $movimiento = $movimiento ?? null;
    $input = fn ($campo) => 'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary '
        . ($errors->has($campo) ? 'border-red-500 bg-red-50' : 'border-line');
    $fechaPorDefecto = ($movimiento?->fecha_movimiento ?? now())->format('Y-m-d\TH:i');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div class="md:col-span-2">
        <label for="producto_id" class="block text-sm font-medium text-ink mb-1">Producto *</label>
        <select id="producto_id" name="producto_id" class="{{ $input('producto_id') }}">
            <option value="">Seleccionar producto...</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id }}" @selected(old('producto_id', $movimiento?->producto_id) == $producto->id)>
                    {{ $producto->codigo }} — {{ $producto->nombre }} (stock: {{ $producto->stock_actual }})
                </option>
            @endforeach
        </select>
        @error('producto_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="tipo" class="block text-sm font-medium text-ink mb-1">Tipo de movimiento *</label>
        <select id="tipo" name="tipo" class="{{ $input('tipo') }}">
            <option value="">Seleccionar tipo...</option>
            @foreach(['entrada' => 'Entrada (suma al stock)', 'salida' => 'Salida (resta del stock)'] as $valor => $texto)
                <option value="{{ $valor }}" @selected(old('tipo', $movimiento?->tipo) === $valor)>{{ $texto }}</option>
            @endforeach
        </select>
        @error('tipo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="cantidad" class="block text-sm font-medium text-ink mb-1">Cantidad *</label>
        <input type="number" min="1" id="cantidad" name="cantidad" value="{{ old('cantidad', $movimiento?->cantidad) }}"
               placeholder="0" class="{{ $input('cantidad') }}">
        @error('cantidad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="fecha_movimiento" class="block text-sm font-medium text-ink mb-1">Fecha y hora *</label>
        <input type="datetime-local" id="fecha_movimiento" name="fecha_movimiento" value="{{ old('fecha_movimiento', $fechaPorDefecto) }}"
               class="{{ $input('fecha_movimiento') }}">
        @error('fecha_movimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-6">
    <label for="observaciones" class="block text-sm font-medium text-ink mb-1">Observaciones</label>
    <textarea id="observaciones" name="observaciones" rows="3" placeholder="Motivo o detalles del movimiento..."
              class="{{ $input('observaciones') }}">{{ old('observaciones', $movimiento?->observaciones) }}</textarea>
    @error('observaciones') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
