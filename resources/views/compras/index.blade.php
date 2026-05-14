<x-layouts::app :title="__('Compras')">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">{{ __('Compras') }}</flux:heading>
        <a href="{{ route('compras.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-zinc-800 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">
            <flux:icon name="plus" class="size-4" />
            Nueva Compra
        </a>
    </div>

    @if(session('success'))
        <div
            class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
            {{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-800">
                <tr>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        ID</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Proveedor</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Fecha</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Total</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                @forelse($compras as $compra)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                            #{{ $compra->id }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                            {{ $compra->proveedor->nombre }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $compra->fecha->format('d/m/Y') }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
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
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-neutral-500 dark:text-neutral-400">No hay
                            compras registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $compras->links() }}</div>
</x-layouts::app>