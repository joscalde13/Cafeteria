<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            if (Schema::hasColumn('compras', 'producto_id')) {
                $table->dropConstrainedForeignId('producto_id');
            }

            if (!Schema::hasColumn('compras', 'concepto')) {
                $table->string('concepto')->after('proveedor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            if (Schema::hasColumn('compras', 'concepto')) {
                $table->dropColumn('concepto');
            }

            if (!Schema::hasColumn('compras', 'producto_id')) {
                $table->foreignId('producto_id')->nullable()->after('proveedor_id')->constrained('productos')->nullOnDelete();
            }
        });
    }
};
