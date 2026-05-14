<x-layouts::app :title="__('Nueva Venta')">
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Registrar Venta') }}</flux:heading>
    </div>

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-400">
            {{ session('error') }}</div>
    @endif

    <div class="mx-auto max-w-4xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <form action="{{ route('ventas.store') }}" method="POST" id="ventaForm">
                @csrf

                <div id="productos-container">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">Productos</h3>
                        <button type="button" onclick="agregarProducto()"
                            class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 transition">
                            <flux:icon name="plus" class="size-3" />
                            Agregar producto
                        </button>
                    </div>

                    <div id="productos-list">
                        <div class="producto-row mb-3 grid grid-cols-12 gap-3 items-end">
                            <div class="col-span-5">
                                <label
                                    class="mb-1 block text-xs font-medium text-neutral-500 dark:text-neutral-400">Producto</label>
                                <select name="productos[0][id]" required onchange="actualizarPrecio(this)"
                                    class="producto-select w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                    <option value="">Seleccionar...</option>
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->id }}" data-precio="{{ $prod->precio }}"
                                            data-stock="{{ $prod->stock }}">
                                            {{ $prod->nombre }} (Stock: {{ $prod->stock }}) -
                                            Q{{ number_format($prod->precio, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="mb-1 block text-xs font-medium text-neutral-500 dark:text-neutral-400">Cantidad</label>
                                <input type="number" name="productos[0][cantidad]" min="1" value="1" required
                                    onchange="calcularTotales()" oninput="calcularTotales()"
                                    class="cantidad-input w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="mb-1 block text-xs font-medium text-neutral-500 dark:text-neutral-400">Precio
                                    Unit.</label>
                                <input type="text" readonly
                                    class="precio-display w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm text-neutral-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-400"
                                    value="Q0.00">
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="mb-1 block text-xs font-medium text-neutral-500 dark:text-neutral-400">Subtotal</label>
                                <input type="text" readonly
                                    class="subtotal-display w-full rounded-lg border border-neutral-200 bg-neutral-50 px-3 py-2 text-sm font-medium text-neutral-700 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300"
                                    value="Q0.00">
                            </div>
                            <div class="col-span-1 flex justify-center">
                                <button type="button" onclick="eliminarProducto(this)"
                                    class="rounded-lg p-1.5 text-red-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 transition">
                                    <flux:icon name="x-mark" class="size-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="mt-6 border-t border-neutral-200 pt-4 dark:border-neutral-700">
                    <div class="flex flex-col items-end gap-2">
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-neutral-500 dark:text-neutral-400">Subtotal:</span>
                            <span id="total-subtotal"
                                class="font-medium text-neutral-900 dark:text-neutral-100">Q0.00</span>
                        </div>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-neutral-500 dark:text-neutral-400">IVA
                                ({{ $porcentajeImpuesto }}%):</span>
                            <span id="total-impuesto"
                                class="font-medium text-neutral-900 dark:text-neutral-100">Q0.00</span>
                        </div>
                        <div class="flex items-center gap-4 text-lg">
                            <span class="font-semibold text-neutral-900 dark:text-neutral-100">Total:</span>
                            <span id="total-general"
                                class="font-bold text-neutral-900 dark:text-neutral-100">Q0.00</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="rounded-lg bg-zinc-800 px-5 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">
                        Registrar Venta
                    </button>
                    <a href="{{ route('ventas.index') }}"
                        class="rounded-lg px-5 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const porcentajeImpuesto = {{ $porcentajeImpuesto }};
        let productoIndex = 1;

        function agregarProducto() {
            const container = document.getElementById('productos-list');
            const row = container.querySelector('.producto-row').cloneNode(true);

            row.querySelector('.producto-select').name = `productos[${productoIndex}][id]`;
            row.querySelector('.producto-select').value = '';
            row.querySelector('.cantidad-input').name = `productos[${productoIndex}][cantidad]`;
            row.querySelector('.cantidad-input').value = 1;
            row.querySelector('.precio-display').value = 'Q0.00';
            row.querySelector('.subtotal-display').value = 'Q0.00';

            container.appendChild(row);
            productoIndex++;
        }

        function eliminarProducto(btn) {
            const rows = document.querySelectorAll('.producto-row');
            if (rows.length > 1) {
                btn.closest('.producto-row').remove();
                calcularTotales();
            }
        }

        function actualizarPrecio(select) {
            const row = select.closest('.producto-row');
            const option = select.options[select.selectedIndex];
            const precio = option.dataset.precio || 0;
            row.querySelector('.precio-display').value = `Q${parseFloat(precio).toFixed(2)}`;
            calcularTotales();
        }

        function calcularTotales() {
            let subtotalGeneral = 0;
            document.querySelectorAll('.producto-row').forEach(row => {
                const select = row.querySelector('.producto-select');
                const option = select.options[select.selectedIndex];
                const precio = parseFloat(option?.dataset?.precio || 0);
                const cantidad = parseInt(row.querySelector('.cantidad-input').value) || 0;
                const subtotal = precio * cantidad;

                row.querySelector('.subtotal-display').value = `Q${subtotal.toFixed(2)}`;
                subtotalGeneral += subtotal;
            });

            const impuesto = subtotalGeneral * (porcentajeImpuesto / 100);
            const total = subtotalGeneral + impuesto;

            document.getElementById('total-subtotal').textContent = `Q${subtotalGeneral.toFixed(2)}`;
            document.getElementById('total-impuesto').textContent = `Q${impuesto.toFixed(2)}`;
            document.getElementById('total-general').textContent = `Q${total.toFixed(2)}`;
        }
    </script>
</x-layouts::app>