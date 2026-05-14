<x-layouts::app :title="__('Impuestos')">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">{{ __('Impuestos') }}</flux:heading>
        <a href="{{ route('impuestos.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-zinc-800 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">
            <flux:icon name="plus" class="size-4" />
            Nuevo Impuesto
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
                        Porcentaje</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Estado</th>
                    <th
                        class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Recordatorio</th>
                    <th
                        class="px-6 py-3 text-end text-xs font-medium uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-700 dark:bg-neutral-900">
                @forelse($impuestos as $imp)
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                            {{ $imp->nombre }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                            {{ $imp->porcentaje }}%</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <span
                                class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $imp->activo ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-neutral-100 text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400' }}">
                                {{ $imp->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                            @if($imp->recordatorio_pago)
                                <span
                                    class="{{ $imp->recordatorio_pago->isPast() ? 'text-red-600 dark:text-red-400 font-medium' : '' }}">
                                    {{ $imp->recordatorio_pago->format('d/m/Y') }}
                                    @if($imp->recordatorio_pago->isPast())
                                        ⚠️ Vencido
                                    @elseif($imp->recordatorio_pago->diffInDays(now()) <= 7)
                                        ⏰ Próximo
                                    @endif
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-end text-sm">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('impuestos.edit', $imp) }}"
                                    class="rounded-lg p-1.5 text-neutral-400 hover:bg-neutral-100 hover:text-neutral-600 dark:hover:bg-neutral-800 dark:hover:text-neutral-300 transition">
                                    <flux:icon name="pencil-square" class="size-4" />
                                </a>
                                <form action="{{ route('impuestos.destroy', $imp) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este impuesto?')">
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
                            impuestos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $impuestos->links() }}</div>
</x-layouts::app>