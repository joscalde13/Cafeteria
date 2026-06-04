<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->foreignId('producto_id')->nullable()->after('proveedor_id')->constrained('productos')->nullOnDelete();
            $table->decimal('cantidad', 10, 2)->default(1)->after('fecha');
            $table->decimal('precio_unitario', 10, 2)->default(0)->after('cantidad');
        });

        // Backfill para no romper registros existentes.
        DB::table('compras')->update([
            'cantidad' => 1,
            'precio_unitario' => DB::raw('total'),
        ]);
    }

    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropConstrainedForeignId('producto_id');
            $table->dropColumn(['cantidad', 'precio_unitario']);
        });
    }
};
