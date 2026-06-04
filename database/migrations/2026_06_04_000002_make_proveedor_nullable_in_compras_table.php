<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
        });

        DB::statement('ALTER TABLE compras MODIFY proveedor_id BIGINT UNSIGNED NULL');

        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->nullOnDelete();
        });
    }

    public function down(): void
    {
        DB::table('compras')->whereNull('proveedor_id')->update(['proveedor_id' => 1]);

        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
        });

        DB::statement('ALTER TABLE compras MODIFY proveedor_id BIGINT UNSIGNED NOT NULL');

        Schema::table('compras', function (Blueprint $table) {
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->cascadeOnDelete();
        });
    }
};
