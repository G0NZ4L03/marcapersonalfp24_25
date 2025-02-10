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
        Schema::create('users_competencias', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->notnullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('competencia_id')->notnullable();
            $table->foreign('competencia_id')->references('id')->on('competencias');

            $table->unsignedBigInteger('docente_validador')->nullable();
            $table->foreign('docente_validador')->references('id')->on(table: 'users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_competencias');
    }
};
