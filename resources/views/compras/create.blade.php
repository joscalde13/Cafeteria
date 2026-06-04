<x-layouts::app :title="__('Nueva Compra')">
    <!-- ENCABEZADO DE PAGINA -->
    <div class="mb-10">
        <flux:heading size="xl">{{ __('Registrar Compra') }}</flux:heading>
    </div>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="mx-auto mb-8 max-w-2xl">
        <div class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <!-- FORMULARIO DE COMPRA -->
            <form action="{{ route('compras.store') }}" method="POST">
                @csrf

                <!-- CAMPOS PRINCIPALES -->
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="concepto"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Compra
                            *</label>
                        <input type="text" name="concepto" id="concepto" value="{{ old('concepto') }}" required
                            placeholder="Ejemplo: 2 sacos de arroz, detergente, servilletas"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('concepto') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fecha"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Fecha
                            *</label>
                        <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('fecha') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="cantidad"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Cantidad
                            *</label>
                        <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', 1) }}" step="0.01" min="0.01"
                            required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('cantidad') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="precio_unitario"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Valor unitario (Q)
                            *</label>
                        <input type="number" name="precio_unitario" id="precio_unitario" value="{{ old('precio_unitario') }}" step="0.01" min="0"
                            required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('precio_unitario') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="total_preview"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Total calculado (Q)</label>
                        <input type="text" id="total_preview" readonly
                            class="w-full rounded-lg border border-neutral-200 bg-cyan-50 px-4 py-2 text-sm font-semibold text-cyan-800 dark:border-cyan-900/50 dark:bg-cyan-950/30 dark:text-cyan-300">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="notas"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Notas</label>
                        <textarea name="notas" id="notas" rows="3"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-cyan-500 focus:ring-cyan-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('notas') }}</textarea>
                    </div>
                </div>

                <!-- ACCIONES DEL FORMULARIO -->
                <div class="mt-8 flex items-center gap-4">
                    <button type="submit"
                        class="rounded-xl bg-cyan-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-cyan-500">Guardar</button>
                    <a href="{{ route('compras.index') }}"
                        class="rounded-lg px-5 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT DE TOTAL AUTOMATICO -->
    <script>
        const cantidadInput = document.getElementById('cantidad');
        const precioInput = document.getElementById('precio_unitario');
        const totalPreview = document.getElementById('total_preview');

        function updateTotal() {
            const cantidad = parseFloat(cantidadInput.value || '0');
            const precio = parseFloat(precioInput.value || '0');
            totalPreview.value = (cantidad * precio).toFixed(2);
        }

        cantidadInput.addEventListener('input', updateTotal);
        precioInput.addEventListener('input', updateTotal);

        updateTotal();
    </script>
</x-layouts::app>