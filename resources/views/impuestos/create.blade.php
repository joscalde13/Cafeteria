<x-layouts::app :title="__('Nuevo Impuesto')">
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Nuevo Impuesto') }}</flux:heading>
    </div>
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <form action="{{ route('impuestos.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nombre"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nombre
                            *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('nombre') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="porcentaje"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Porcentaje (%)
                            *</label>
                        <input type="number" name="porcentaje" id="porcentaje" value="{{ old('porcentaje', 12) }}"
                            step="0.01" min="0" max="100" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('porcentaje') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="recordatorio_pago"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Recordatorio
                            de Pago</label>
                        <input type="date" name="recordatorio_pago" id="recordatorio_pago"
                            value="{{ old('recordatorio_pago') }}"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}
                                class="rounded border-neutral-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600">
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Activo</span>
                        </label>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="rounded-lg bg-zinc-800 px-5 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">Guardar</button>
                    <a href="{{ route('impuestos.index') }}"
                        class="rounded-lg px-5 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>