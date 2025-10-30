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
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->date('permission_date')->comment('Fecha del permiso');
            $table->time('start_time')->comment('Hora de inicio');
            $table->time('end_time')->comment('Hora de fin');
            $table->time('departure_time')->nullable()->comment('Hora de salida');
            $table->string('reasons')->comment('Motivo del permiso');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('apprentice_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('guard_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status')->comment('Estado');
            $table->foreignId('location_id')->constrained('location')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('permission_type_id')->constrained('permission_type')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
