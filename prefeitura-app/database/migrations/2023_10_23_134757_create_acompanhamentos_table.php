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
        Schema::create('acompanhamentos', function (Blueprint $table) {
            $table->id();
            $table->string('observacao');
            $table->unsignedBigInteger('protocolo_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('protocolo_id')->references('id')->on('protocolos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acompanhamentos');
    }
};
