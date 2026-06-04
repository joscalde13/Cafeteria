<x-layouts::app :title="__('Compras')">
    <!-- ENCABEZADO PRINCIPAL -->
    <div class="mb-10 flex flex-wrap items-center justify-between gap-6">
        <div class="space-y-2">
            <flux:heading size="xl">{{ __('Compras') }}</flux:heading>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Controla lo comprado por producto y su costo total.</p>
        </div>
        <a href="{{ route('compras.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-cyan-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-500">
            <flux:icon name="plus" class="size-4" />
            Nueva Compra
        </a>
    </div>

    <!-- MENSAJE DE EXITO -->
    @if(session('success'))
        <div
            class="mb-8 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLA DE COMPRAS -->
    <div class="mb-8 overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50/90 dark:bg-neutral-800/70">
                <tr>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Compra</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Cantidad</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Valor Unitario</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Fecha</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Total</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                @forelse($compras as $compra)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                        <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-200">
                            {{ $compra->concepto }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-end text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                            {{ number_format((float) $compra->cantidad, 2) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-end text-sm text-neutral-700 dark:text-neutral-300">
                            Q{{ number_format((float) $compra->precio_unitario, 2) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $compra->fecha->format('d/m/Y') }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-end text-sm font-bold text-cyan-700 dark:text-cyan-400">
                            Q{{ number_format($compra->total, 2) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-end text-sm">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('compras.show', $compra) }}"
                                    class="rounded-lg p-1.5 text-neutral-400 hover:bg-neutral-100 hover:text-neutral-600 dark:hover:bg-neutral-800 dark:hover:text-neutral-300 transition">
                                    <flux:icon name="eye" class="size-4" />
                                </a>
                                <a href="{{ route('compras.edit', $compra) }}"
                                    class="rounded-lg p-1.5 text-neutral-400 hover:bg-neutral-100 hover:text-neutral-600 dark:hover:bg-neutral-800 dark:hover:text-neutral-300 transition">
                                    <flux:icon name="pencil-square" class="size-4" />
                                </a>
                                <form action="{{ route('compras.destroy', $compra) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta compra?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="rounded-lg p-1.5 text-red-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition">
                                        <flux:icon name="trash" class="size-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">No hay
                            compras registradas.</td>
                    </tr>
                @endforelse
            </tbody>
            @if($compras->count())
                <tfoot class="bg-neutral-50 dark:bg-neutral-800/70">
                    <tr>
                        <td class="px-6 py-3 text-sm font-semibold text-neutral-700 dark:text-neutral-200">
                            Total de todas las compras
                        </td>
                        <td class="px-6 py-3 text-end text-sm font-bold text-neutral-900 dark:text-neutral-100">
                            {{ number_format((float) $compras->sum('cantidad'), 2) }}
                        </td>
                        <td class="px-6 py-3"></td>
                        <td class="px-6 py-3"></td>
                        <td class="px-6 py-3 text-end text-sm font-bold text-cyan-700 dark:text-cyan-400">
                            Q{{ number_format((float) $compras->sum('total'), 2) }}
                        </td>
                        <td class="px-6 py-3"></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>

    <!-- PAGINACION -->
    <div class="mt-8">{{ $compras->links() }}</div>
</x-layouts::app>