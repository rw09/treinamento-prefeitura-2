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
        Schema::create('contribuintes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->date('data_nascimento');
            $table->string('cpf', 20)->unique();
            $table->char('sexo');
            $table->string('cidade', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('rua', 100)->nullable();
            $table->smallInteger('numero')->nullable();
            $table->string('complemento', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuintes');
    }
};
