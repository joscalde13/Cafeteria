<x-layouts::app :title="__('Nuevo Movimiento')">
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Registrar Movimiento de Inventario') }}</flux:heading>
    </div>

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-400">
            {{ session('error') }}</div>
    @endif

    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <form action="{{ route('inventario.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="producto_id"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Producto
                            *</label>
                        <select name="producto_id" id="producto_id" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Seleccionar...</option>
                            @foreach($productos as $prod)
                                <option value="{{ $prod->id }}" {{ old('producto_id') == $prod->id ? 'selected' : '' }}>
                                    {{ $prod->nombre }} (Stock actual: {{ $prod->stock }})</option>
                            @endforeach
                        </select>
                        @error('producto_id') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tipo"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Tipo *</label>
                        <select name="tipo" id="tipo" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                        </select>
                        @error('tipo') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="cantidad"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Cantidad
                            *</label>
                        <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', 1) }}" min="1"
                            required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('cantidad') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="motivo"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Motivo</label>
                        <input type="text" name="motivo" id="motivo" value="{{ old('motivo') }}"
                            placeholder="Ej: Compra de proveedor, Ajuste de inventario..."
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                </div>
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="rounded-lg bg-zinc-800 px-5 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">Registrar</button>
                    <a href="{{ route('inventario.index') }}"
                        class="rounded-lg px-5 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>