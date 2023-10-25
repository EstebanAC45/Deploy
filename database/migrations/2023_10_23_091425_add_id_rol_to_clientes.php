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
        Schema::table('clientes', function (Blueprint $table) {
            //
            $table->bigInteger('id_rol')->unsigned()->nullable();
            $table->foreign('id_rol')->references('id')->on('rols')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
            $table->dropForeign('clientes_id_rol_foreign');
            $table->dropColumn('id_rol');
        });
    }
};
