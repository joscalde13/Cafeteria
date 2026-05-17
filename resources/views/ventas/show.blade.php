<x-layouts::app :title="'Venta #' . $venta->id">
    <div class="mb-6 flex items-center justify-between">
        <flux:heading size="xl">Venta #{{ $venta->id }}</flux:heading>
        <a href="{{ route('ventas.index') }}"
            class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">
            <flux:icon name="arrow-left" class="size-4" />
            Volver
        </a>
    </div>

    <div class="mx-auto max-w-3xl">
        <!-- Sale Info -->
        <div class="mb-6 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <dl class="grid gap-4 sm:grid-cols-3">
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Fecha</dt>
                    <dd class="text-sm text-neutral-900 dark:text-neutral-100">{{ $venta->fecha->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Vendedor</dt>
                    <dd class="text-sm text-neutral-900 dark:text-neutral-100">{{ $venta->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Total</dt>
                    <dd class="text-lg font-bold text-neutral-900 dark:text-neutral-100">
                        Q{{ number_format($venta->total, 2) }}</dd>
                </div>
            </dl>
        </div>

        <!-- Sale Details -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Producto</th>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Cantidad</th>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Precio Unit.</th>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                    @foreach($venta->detalles as $detalle)
                        <tr>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {{ $detalle->producto->nombre }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $detalle->cantidad }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                                Q{{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                Q{{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <td colspan="3"
                            class="px-6 py-3 text-end text-sm font-bold text-neutral-900 dark:text-neutral-100">Total:
                        </td>
                        <td class="px-6 py-3 text-sm font-bold text-neutral-900 dark:text-neutral-100">
                            Q{{ number_format($venta->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-layouts::app>