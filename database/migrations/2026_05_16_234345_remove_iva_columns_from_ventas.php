<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'impuesto']);
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('fecha');
            $table->decimal('impuesto', 10, 2)->default(0)->after('subtotal');
        });
    }
};
