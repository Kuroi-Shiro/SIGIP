{{--
    Parcial: lista dinámica de productos de una entrega.
    Recibe: $productos (catálogo activo) y $seleccionados (array de ['producto_id' => , 'cantidad' => ]).
--}}
@php
    $filas = array_values(old('productos', $seleccionados ?? []));
    if (empty($filas)) {
        $filas = [['producto_id' => '', 'cantidad' => 1]];
    }
@endphp

<div class="mb-6">
    <div class="flex items-center justify-between mb-2">
        <label class="block text-sm font-medium text-ink">Productos *</label>
        <button type="button" id="agregar-fila"
                class="text-xs px-2.5 py-1 rounded-lg border border-line text-muted hover:border-primary hover:text-primary transition-colors">
            + Agregar producto
        </button>
    </div>

    <div id="filas" class="space-y-2">
        @foreach($filas as $i => $fila)
            <div data-fila class="flex items-start gap-2">
                <div class="flex-1">
                    <select name="productos[{{ $i }}][producto_id]"
                            @class([
                                'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                                'border-red-500 bg-red-50' => $errors->has("productos.$i.producto_id"),
                                'border-line' => !$errors->has("productos.$i.producto_id"),
                            ])>
                        <option value="">Seleccionar producto...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" @selected(($fila['producto_id'] ?? '') == $producto->id)>
                                {{ $producto->codigo }} — {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error("productos.$i.producto_id") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="w-28">
                    <input type="number" min="1" name="productos[{{ $i }}][cantidad]"
                           value="{{ $fila['cantidad'] ?? 1 }}" placeholder="Cant."
                           @class([
                               'w-full border rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary',
                               'border-red-500 bg-red-50' => $errors->has("productos.$i.cantidad"),
                               'border-line' => !$errors->has("productos.$i.cantidad"),
                           ])>
                    @error("productos.$i.cantidad") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="button" data-quitar
                        class="px-3 py-2 text-xs text-muted hover:text-danger transition-colors">Quitar</button>
            </div>
        @endforeach
    </div>

    @error('productos') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
</div>

<template id="fila-plantilla">
    <div data-fila class="flex items-start gap-2">
        <div class="flex-1">
            <select name="productos[__INDEX__][producto_id]"
                    class="w-full border border-line rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary">
                <option value="">Seleccionar producto...</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->codigo }} — {{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-28">
            <input type="number" min="1" name="productos[__INDEX__][cantidad]" value="1" placeholder="Cant."
                   class="w-full border border-line rounded-lg px-3 py-2 text-sm outline-none transition-colors focus:border-primary">
        </div>
        <button type="button" data-quitar
                class="px-3 py-2 text-xs text-muted hover:text-danger transition-colors">Quitar</button>
    </div>
</template>

<script>
    (function () {
        const contenedor = document.getElementById('filas');
        const plantilla = document.getElementById('fila-plantilla').innerHTML;
        let indice = {{ count($filas) }};

        document.getElementById('agregar-fila').addEventListener('click', function () {
            contenedor.insertAdjacentHTML('beforeend', plantilla.replaceAll('__INDEX__', indice++));
        });

        contenedor.addEventListener('click', function (e) {
            const boton = e.target.closest('[data-quitar]');
            if (!boton) return;
            // Siempre debe quedar al menos una fila
            if (contenedor.querySelectorAll('[data-fila]').length > 1) {
                boton.closest('[data-fila]').remove();
            }
        });
    })();
</script>