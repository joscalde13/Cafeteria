<x-layouts::app :title="$producto->nombre">
    <!-- ENCABEZADO DE PAGINA -->
    <div class="mb-6 flex items-center justify-between">
        <flux:heading size="xl">{{ $producto->nombre }}</flux:heading>
        <a href="{{ route('productos.index') }}"
            class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">
            <flux:icon name="arrow-left" class="size-4" />
            Volver
        </a>
    </div>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <!-- IMAGEN Y DETALLE DEL PRODUCTO -->
            <div class="flex gap-6">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                        class="h-40 w-40 rounded-xl object-cover">
                @else
                    <div class="flex h-40 w-40 items-center justify-center rounded-xl bg-neutral-100 dark:bg-neutral-800">
                        <flux:icon name="cube" class="size-12 text-neutral-400" />
                    </div>
                @endif
                <div class="flex-1">
                    <dl class="grid gap-3">
                        <div>
                            <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Categoría
                            </dt>
                            <dd class="text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $producto->categoria->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Precio</dt>
                            <dd class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                                Q{{ number_format($producto->precio, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Stock</dt>
                            <dd>
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $producto->stock < 10 ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' }}">
                                    {{ $producto->stock }} unidades
                                </span>
                            </dd>
                        </div>
                        @if($producto->descripcion)
                            <div>
                                <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Descripción
                                </dt>
                                <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $producto->descripcion }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>