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
        Schema::create('protocolos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->smallInteger('prazo');
            $table->tinyInteger('situacao')->default(0);
            $table->unsignedBigInteger('contribuinte_id');
            $table->unsignedBigInteger('departamento_id');
            $table->timestamps();

            $table->foreign('contribuinte_id')->references('id')->on('contribuintes')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protocolos');
    }
};
