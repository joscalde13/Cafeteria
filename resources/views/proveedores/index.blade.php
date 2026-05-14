<x-layouts::app :title="__('Proveedores')">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">{{ __('Proveedores') }}</flux:heading>
        <a href="{{ route('proveedores.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-zinc-800 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">
            <flux:icon name="plus" class="size-4" />
            Nuevo Proveedor
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
                        Nombre</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Contacto</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Teléfono</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Email</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Compras</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                @forelse($proveedores as $proveedor)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                            {{ $proveedor->nombre }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $proveedor->contacto ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $proveedor->telefono ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $proveedor->email ?? '—' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <span
                                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ $proveedor->compras_count }}</span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-end text-sm">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('proveedores.edit', $proveedor) }}"
                                    class="rounded-lg p-1.5 text-neutral-400 hover:bg-neutral-100 hover:text-neutral-600 dark:hover:bg-neutral-800 dark:hover:text-neutral-300 transition">
                                    <flux:icon name="pencil-square" class="size-4" />
                                </a>
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este proveedor?')">
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
                            proveedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $proveedores->links() }}</div>
</x-layouts::app>