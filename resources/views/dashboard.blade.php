<x-layouts::app :title="__('Dashboard')">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">{{ __('Dashboard') }}</flux:heading>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Resumen general de la cafetería</p>
        </div>
        <div class="flex flex-col items-end gap-2">

            <!-- formulario de cerrar sesion -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-xs font-semibold uppercase tracking-wider text-neutral-500 hover:text-red-600 transition-colors bg-white border border-neutral-200 px-2 py-1 rounded-md flex items-center gap-1.5 hover:border-red-200 hover:bg-red-50 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-red-400 dark:hover:bg-red-900/20 dark:hover:border-red-800">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Cerrar Sesión
                </button>
            </form>

            <div
                class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium border border-neutral-200 text-neutral-600 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                <flux:icon name="calendar" class="size-4 text-blue-500" />
                <span>{{ $fechaGuatemala }}</span>
            </div>
        </div>
    </div>

    {{-- Card de Impuesto Mensual (solo admin) --}}
    @if(auth()->user()->isAdmin())
        @php
            $hoyGt = \Carbon\Carbon::now('America/Guatemala');
            $mesesNombres = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            // El impuesto es sobre las ventas del MES ACTUAL
            $mesImpuesto = $hoyGt->month;
            $anioImpuesto = $hoyGt->year;
            $nombreMesImpuesto = $mesesNombres[$mesImpuesto - 1];

            // Ventas del mes actual
            $ventasMesActual = \App\Models\Venta::whereMonth('fecha', $mesImpuesto)
                ->whereYear('fecha', $anioImpuesto)
                ->sum('total');
            $montoImpuesto = $ventasMesActual * 0.05;

            // Fecha límite: 1ro del mes siguiente (cada 1ro se reinicia el ciclo)
            $fechaLimite = $hoyGt->copy()->addMonth()->startOfMonth();
            $diasRestantes = (int) $hoyGt->diffInDays($fechaLimite, false);

            // Estado: rojo si ya venció (no debería pasar con este cálculo), amarillo si quedan días
            if ($diasRestantes <= 3) {
                $estado = 'vencido';
            } else {
                $estado = 'pendiente';
            }
        @endphp

        <div class="mb-6 rounded-xl border shadow-sm overflow-hidden
                {{ $estado === 'vencido' ? 'border-red-300 dark:border-red-800/60' : '' }}
                {{ $estado === 'pendiente' ? 'border-amber-300 dark:border-amber-800/60' : '' }}
                ">

            {{-- Barra superior de color --}}
            <div class="h-1.5
                    {{ $estado === 'vencido' ? 'bg-gradient-to-r from-red-500 to-red-600' : '' }}
                    {{ $estado === 'pendiente' ? 'bg-gradient-to-r from-amber-400 to-amber-500' : '' }}
                    "></div>

            <div class="bg-white p-5 dark:bg-neutral-900">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    {{-- Icono + Texto principal --}}
                    <div class="flex items-start gap-4">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-xl
                                {{ $estado === 'vencido' ? 'bg-red-100 dark:bg-red-900/30' : '' }}
                                {{ $estado === 'pendiente' ? 'bg-amber-100 dark:bg-amber-900/30' : '' }}">
                            @if($estado === 'vencido')
                                <flux:icon name="exclamation-triangle" class="size-6 text-red-600 dark:text-red-400" />
                            @else
                                <flux:icon name="clock" class="size-6 text-amber-600 dark:text-amber-400" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold
                                    {{ $estado === 'vencido' ? 'text-red-800 dark:text-red-300' : '' }}
                                    {{ $estado === 'pendiente' ? 'text-amber-800 dark:text-amber-300' : '' }}">
                                @if($estado === 'vencido')
                                    ¡Quedan {{ $diasRestantes }} día{{ $diasRestantes !== 1 ? 's' : '' }}!
                                @else
                                    Impuesto de {{ $nombreMesImpuesto }}
                                @endif
                            </h3>
                            <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                                @if($estado === 'vencido')
                                    Le quedan <strong>{{ $diasRestantes }}</strong> día{{ $diasRestantes !== 1 ? 's' : '' }}
                                    para pagar el impuesto de <strong>{{ $nombreMesImpuesto }}</strong>. Monto:
                                    <strong>Q{{ number_format($montoImpuesto, 2) }}</strong>
                                @else
                                    Le quedan <strong>{{ $diasRestantes }}</strong> día{{ $diasRestantes !== 1 ? 's' : '' }}
                                    para pagar el impuesto de <strong>{{ $nombreMesImpuesto }}</strong>. Monto:
                                    <strong>Q{{ number_format($montoImpuesto, 2) }}</strong>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Monto + Fecha --}}
                    <div class="flex items-center gap-6 sm:text-end">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                Monto a pagar</p>
                            <p class="mt-0.5 text-xl font-bold
                                    {{ $estado === 'vencido' ? 'text-red-600 dark:text-red-400' : '' }}
                                    {{ $estado === 'pendiente' ? 'text-amber-600 dark:text-amber-400' : '' }}">
                                Q{{ number_format($montoImpuesto, 2) }}
                            </p>
                        </div>
                        <div class="border-l border-neutral-200 pl-6 dark:border-neutral-700">
                            <p class="text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                                Fecha límite</p>
                            <p class="mt-0.5 text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                                1 de {{ $mesesNombres[$fechaLimite->month - 1] }} {{ $fechaLimite->year }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Link al módulo de impuestos --}}
                <div class="mt-4 border-t border-neutral-100 pt-3 dark:border-neutral-800">
                    <a href="{{ route('impuestos-mensuales.index', ['mes' => $mesImpuesto, 'anio' => $anioImpuesto]) }}"
                        class="inline-flex items-center gap-1.5 text-xs font-medium
                            {{ $estado === 'vencido' ? 'text-red-600 hover:text-red-700 dark:text-red-400' : '' }}
                            {{ $estado === 'pendiente' ? 'text-amber-600 hover:text-amber-700 dark:text-amber-400' : '' }}

                            transition">
                        Ver detalle del impuesto
                        <flux:icon name="arrow-right" class="size-3.5" />
                    </a>
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
            class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm dark:border-neutral-700/50 dark:bg-neutral-900 lg:col-span-3">
            <h3 class="mb-4 text-sm font-semibold text-neutral-700 dark:text-neutral-300">Ventas - Últimos 7 días</h3>
            <div class="h-64 w-full">
                <canvas id="ventasChart"></canvas>
            </div>
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
                                        {{ $prod->nombre }}
                                    </td>
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