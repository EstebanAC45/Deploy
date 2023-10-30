<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            //
            $table->dropForeign('ventas_numero_venta_foreign');

        });

        Schema::table('carritos', function (Blueprint $table) {
            //
            $table->dropColumn('numero_venta');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carritos', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('numero_venta');
        });
        Schema::table('ventas', function (Blueprint $table) {
            //
            $table->foreign('numero_venta')->references('numero_venta')->on('carritos');

        });
    }
};
