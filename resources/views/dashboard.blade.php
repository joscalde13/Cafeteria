<x-layouts::app :title="__('Dashboard')">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">{{ __('Dashboard') }}</flux:heading>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Resumen general de la cafetería</p>
        </div>
        <div
            class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium border border-neutral-200 text-neutral-600 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
            <flux:icon name="calendar" class="size-4 text-blue-500" />
            <span>{{ $fechaGuatemala }}</span>
        </div>
    </div>

    <!-- Tax Reminders Alert -->
    @if($impuestosProximos->count() > 0)
        <div
            class="mb-6 rounded-xl border border-amber-200 bg-gradient-to-r from-amber-50 to-white p-4 shadow-sm dark:border-amber-800/50 dark:from-amber-900/20 dark:to-neutral-900">
            <div class="flex items-start gap-3">
                <div class="rounded-full bg-amber-100 p-2 dark:bg-amber-900/50">
                    <flux:icon name="bell-alert" class="size-5 text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-300">Recordatorios de Impuestos Próximos
                    </h3>
                    <div class="mt-1 space-y-1">
                        @foreach($impuestosProximos as $imp)
                            <p class="text-sm text-amber-700 dark:text-amber-400/90">
                                <strong>{{ $imp->nombre }}</strong> — Vence el: {{ $imp->recordatorio_pago->format('d/m/Y') }}
                                @if($imp->recordatorio_pago->isPast())
                                    <span class="font-bold text-red-600 dark:text-red-400 ml-1">(Vencido)</span>
                                @else
                                    <span class="ml-1 opacity-75">(En {{ $imp->recordatorio_pago->diffInDays(now()) }} días)</span>
                                @endif
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Ventas Hoy</p>
                    <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        Q{{ number_format($ventasHoy, 2) }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-900/10">
                    <flux:icon name="banknotes" class="size-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>

        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Ventas del Mes</p>
                    <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        Q{{ number_format($ventasMes, 2) }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/10">
                    <flux:icon name="chart-bar" class="size-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>

        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">Total
                        Productos</p>
                    <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalProductos }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-900/10">
                    <flux:icon name="cube" class="size-6 text-purple-600 dark:text-purple-400" />
                </div>
            </div>
        </div>

        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:shadow-md transition dark:border-neutral-700/50 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Categorías</p>
                    <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalCategorias }}</p>
                </div>
                <div
                    class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/30 dark:to-amber-900/10">
                    <flux:icon name="tag" class="size-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Sales Chart (Spans 2 columns) -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-neutral-700/50 dark:bg-neutral-900 lg:col-span-2">
            <h3 class="mb-4 text-sm font-semibold text-neutral-700 dark:text-neutral-300">Ventas - Últimos 7 días</h3>
            <div class="h-64 w-full">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>

        <!-- Latest Sales -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-neutral-700/50 dark:bg-neutral-900">
            <h3 class="mb-4 text-sm font-semibold text-neutral-700 dark:text-neutral-300">Últimas Ventas</h3>
            @if($ventasRecientes->count() > 0)
                <div class="space-y-4">
                    @foreach($ventasRecientes as $venta)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-8 items-center justify-center rounded-full bg-neutral-100 dark:bg-neutral-800">
                                    <flux:icon name="user" class="size-4 text-neutral-500" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                        {{ $venta->user->name ?? 'Sistema' }}</p>
                                    <p class="text-xs text-neutral-500">{{ $venta->created_at->format('h:i A') }}</p>
                                </div>
                            </div>
                            <span
                                class="text-sm font-bold text-emerald-600 dark:text-emerald-400">Q{{ number_format($venta->total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-neutral-400">Aún no hay ventas registradas.</p>
            @endif
        </div>

        <!-- Top Selling Products -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-neutral-700/50 dark:bg-neutral-900 lg:col-span-3">
            <h3 class="mb-4 text-sm font-semibold text-neutral-700 dark:text-neutral-300">Productos Más Vendidos (Este
                Mes)</h3>
            @if($productosMasVendidos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-neutral-600 dark:text-neutral-400">
                        <thead
                            class="border-b border-neutral-200 text-xs uppercase text-neutral-500 dark:border-neutral-700 dark:text-neutral-500">
                            <tr>
                                <th class="py-3 font-medium">Producto</th>
                                <th class="py-3 font-medium text-center">Unidades Vendidas</th>
                                <th class="py-3 font-medium text-end">Stock Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productosMasVendidos as $prod)
                                <tr class="border-b border-neutral-100 last:border-0 dark:border-neutral-800">
                                    <td class="py-3 font-medium text-neutral-900 dark:text-neutral-100 whitespace-nowrap">
                                        {{ $prod->nombre }}</td>
                                    <td class="py-3 text-center">
                                        <span
                                            class="inline-flex rounded-full bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $prod->total_vendido }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-end">
                                        <span
                                            class="text-neutral-500 @if($prod->stock < 10) font-bold text-red-500 @endif">{{ $prod->stock }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-neutral-400">No hay información de ventas este mes.</p>
            @endif
        </div>
    </div>

    <!-- Scripts para gráficas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        const ctx = document.getElementById('ventasChart').getContext('2d');

        const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($ventasSemana)->pluck('fecha')) !!},
                datasets: [{
                    label: 'Ventas (Q)',
                    data: {!! json_encode(collect($ventasSemana)->pluck('total')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDarkMode ? '#171717' : '#fff',
                        titleColor: isDarkMode ? '#e5e5e5' : '#171717',
                        bodyColor: isDarkMode ? '#a3a3a3' : '#525252',
                        borderColor: isDarkMode ? '#404040' : '#e5e5e5',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return 'Total: Q' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'Q' + value.toFixed(2),
                            color: isDarkMode ? '#737373' : '#a3a3a3'
                        },
                        grid: {
                            color: isDarkMode ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                        },
                        border: { display: false }
                    },
                    x: {
                        ticks: {
                            color: isDarkMode ? '#737373' : '#a3a3a3'
                        },
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    </script>
</x-layouts::app>