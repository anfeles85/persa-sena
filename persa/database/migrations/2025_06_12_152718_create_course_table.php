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
        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number_group')->unique()->comment('Numero de ficha');
            $table->string('shift', 50)->comment('Jornada');
            $table->string('trimester', 50)->comment('Trimestre académico');
            $table->integer('year')->comment('Año');
            $table->string('status', 50)->comment('Estado');
            $table->foreignId('career_id')->constrained('career')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
