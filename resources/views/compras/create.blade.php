<x-layouts::app :title="__('Nueva Compra')">
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Registrar Compra') }}</flux:heading>
    </div>
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <form action="{{ route('compras.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="proveedor_id"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Proveedor
                            *</label>
                        <select name="proveedor_id" id="proveedor_id" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Seleccionar...</option>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id }}" {{ old('proveedor_id') == $prov->id ? 'selected' : '' }}>
                                    {{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                        @error('proveedor_id') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fecha"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Fecha
                            *</label>
                        <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('fecha') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="total"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Total (Q)
                            *</label>
                        <input type="number" name="total" id="total" value="{{ old('total') }}" step="0.01" min="0"
                            required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('total') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="notas"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Notas</label>
                        <textarea name="notas" id="notas" rows="3"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('notas') }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="rounded-lg bg-zinc-800 px-5 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">Guardar</button>
                    <a href="{{ route('compras.index') }}"
                        class="rounded-lg px-5 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>