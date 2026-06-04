<x-layouts::app :title="__('Impuesto del Mes')">
    <!-- ENCABEZADO DE PAGINA -->
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Impuesto del Mes') }}</flux:heading>
        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Resumen mensual de ventas e impuesto del 5%</p>
    </div>

    <!-- FILTRO DE MES Y AÑO -->
    <div
        class="mb-6 rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-neutral-700/50 dark:bg-neutral-900">
        <form method="GET" action="{{ route('impuestos-mensuales.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label
                    class="mb-1 block text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Mes</label>
                <select name="mes" onchange="this.form.submit()"
                    class="rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    @foreach($meses as $num => $nombre)
                        <option value="{{ $num }}" {{ $mesSeleccionado == $num ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <a href="{{ route('impuestos-mensuales.pdf', ['mes' => $mesSeleccionado, 'anio' => $anioSeleccionado]) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition shadow-sm">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Descargar PDF
                </a>
            </div>
        </form>
    </div>

    <!-- CARDS DE RESUMEN -->
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <!-- TOTAL VENTAS -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Total Ventas</p>
                    <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        Q{{ number_format($totalVentas, 2) }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/10">
                    <flux:icon name="banknotes" class="size-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <!-- IMPUESTO 5% -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Impuesto a Pagar (5%)</p>
                    <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">
                        Q{{ number_format($impuesto, 2) }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-900/10">
                    <flux:icon name="receipt-percent" class="size-6 text-red-600 dark:text-red-400" />
                </div>
            </div>
        </div>

        <!-- Ganancia Final -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Ganancia Final</p>
                    <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                        Q{{ number_format($ganancia, 2) }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-900/10">
                    <flux:icon name="arrow-trending-up" class="size-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas del Mes -->
    <div class="rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700/50 dark:bg-neutral-900">
        <div class="border-b border-neutral-200 px-5 py-4 dark:border-neutral-700">
            <h3 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                Ventas de {{ $meses[$mesSeleccionado] }} {{ $anioSeleccionado }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Fecha</th>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            # Venta</th>
                        <th
                            class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Usuario</th>
                        <th
                            class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                            Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                    @forelse($ventas as $venta)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $venta->fecha->format('d/m/Y') }}
                            </td>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                #{{ $venta->id }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $venta->user->name }}
                            </td>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-neutral-900 dark:text-neutral-100 text-end">
                                Q{{ number_format($venta->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                No hay ventas registradas en {{ $meses[$mesSeleccionado] }} {{ $anioSeleccionado }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($ventas->count() > 0)
                    <tfoot class="bg-neutral-50 dark:bg-neutral-800">
                        <tr>
                            <td colspan="3"
                                class="px-6 py-3 text-end text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                                Total del Mes:</td>
                            <td class="px-6 py-3 text-end text-sm font-bold text-neutral-900 dark:text-neutral-100">
                                Q{{ number_format($totalVentas, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-end text-sm font-semibold text-red-600 dark:text-red-400">
                                Impuesto (5%):</td>
                            <td class="px-6 py-3 text-end text-sm font-bold text-red-600 dark:text-red-400">
                                Q{{ number_format($impuesto, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"
                                class="px-6 py-3 text-end text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                Ganancia Final:</td>
                            <td class="px-6 py-3 text-end text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                Q{{ number_format($ganancia, 2) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</x-layouts::app>