{{--
    Parcial: campos generales de una entrega (compartido por create y edit).
    Recibe: $entrega (opcional; null al crear).
--}}
@php
    $entrega = $entrega ?? null;
    $input = fn ($campo) => 'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary '
        . ($errors->has($campo) ? 'border-red-500 bg-red-50' : 'border-line');
    $fechaPorDefecto = $entrega
        ? \Carbon\Carbon::parse($entrega->fecha_entrega)->format('Y-m-d')
        : now()->format('Y-m-d');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label for="cliente" class="block text-sm font-medium text-ink mb-1">Cliente *</label>
        <input type="text" id="cliente" name="cliente" value="{{ old('cliente', $entrega?->cliente) }}"
               placeholder="Nombre del cliente" class="{{ $input('cliente') }}">
        @error('cliente') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="telefono_cliente" class="block text-sm font-medium text-ink mb-1">Teléfono del cliente *</label>
        <input type="text" id="telefono_cliente" name="telefono_cliente" value="{{ old('telefono_cliente', $entrega?->telefono_cliente) }}"
               placeholder="Ej. 614 123 4567" class="{{ $input('telefono_cliente') }}">
        @error('telefono_cliente') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label for="destino" class="block text-sm font-medium text-ink mb-1">Destino *</label>
        <input type="text" id="destino" name="destino" value="{{ old('destino', $entrega?->destino) }}"
               placeholder="Dirección de entrega" class="{{ $input('destino') }}">
        @error('destino') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="estado" class="block text-sm font-medium text-ink mb-1">Estado *</label>
        <select id="estado" name="estado" class="{{ $input('estado') }}">
            @foreach(['pendiente' => 'Pendiente', 'completado' => 'Completado', 'cancelado' => 'Cancelado'] as $valor => $texto)
                <option value="{{ $valor }}" @selected(old('estado', $entrega?->estado ?? 'pendiente') === $valor)>{{ $texto }}</option>
            @endforeach
        </select>
        @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="fecha_entrega" class="block text-sm font-medium text-ink mb-1">Fecha de entrega *</label>
        <input type="date" id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega', $fechaPorDefecto) }}"
               class="{{ $input('fecha_entrega') }}">
        @error('fecha_entrega') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mb-6">
    <label for="observaciones" class="block text-sm font-medium text-ink mb-1">Observaciones</label>
    <textarea id="observaciones" name="observaciones" rows="3" placeholder="Notas de la entrega..."
              class="{{ $input('observaciones') }}">{{ old('observaciones', $entrega?->observaciones) }}</textarea>
    @error('observaciones') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>