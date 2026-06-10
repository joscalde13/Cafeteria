<x-layouts::app :title="__('Inventario')">
    <!-- ENCABEZADO PRINCIPAL -->
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">{{ __('Movimientos de Inventario') }}</flux:heading>
        <a href="{{ route('inventario.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-zinc-800 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">
            <flux:icon name="plus" class="size-4" />
            Nuevo Movimiento
        </a>
    </div>

    <!-- MENSAJES DE SESION -->
    @if(session('success'))
        <div
            class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
            {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-400">
            {{ session('error') }}</div>
    @endif

    <!-- TABLA DE MOVIMIENTOS -->
    <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-800">
                <tr>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Fecha</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Producto</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Tipo</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Cantidad</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Motivo</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Usuario</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                @forelse($movimientos as $mov)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $mov->created_at->format('d/m/Y H:i') }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                            {{ $mov->producto->nombre }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <span
                                class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $mov->tipo === 'entrada' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                {{ ucfirst($mov->tipo) }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                            <span
                                class="{{ $mov->tipo === 'entrada' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $mov->tipo === 'entrada' ? '+' : '-' }}{{ $mov->cantidad }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">{{ $mov->motivo ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $mov->user->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">No hay
                            movimientos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- PAGINACION -->
    <div class="mt-4">{{ $movimientos->links() }}</div>
</x-layouts::app>