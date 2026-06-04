<x-layouts::app :title="__('Detalle de Compra')">
    <!-- ENCABEZADO DE PAGINA -->
    <div class="mb-10 flex items-center justify-between">
        <flux:heading size="xl">Compra #{{ $compra->id }}</flux:heading>
        <a href="{{ route('compras.index') }}"
            class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">
            <flux:icon name="arrow-left" class="size-4" />
            Volver
        </a>
    </div>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="mx-auto mb-8 max-w-2xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <!-- DETALLE DE COMPRA -->
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Fecha</dt>
                    <dd class="text-sm text-neutral-900 dark:text-neutral-100">{{ $compra->fecha->format('d/m/Y') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Compra</dt>
                    <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                        {{ $compra->concepto }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Cantidad</dt>
                    <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                        {{ number_format((float) $compra->cantidad, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Valor Unitario</dt>
                    <dd class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                        Q{{ number_format((float) $compra->precio_unitario, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Total</dt>
                    <dd class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                        Q{{ number_format($compra->total, 2) }}</dd>
                </div>
                @if($compra->notas)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Notas</dt>
                        <dd class="text-sm text-neutral-700 dark:text-neutral-300">{{ $compra->notas }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</x-layouts::app>