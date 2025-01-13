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
        Schema::create('teacher_schedules', function (Blueprint $table) {
            $table->id(); // ID-ul unic al rândului
            $table->unsignedBigInteger('teacher_id'); // ID-ul profesorului
            $table->string('day_of_week'); // Ziua săptămânii (ex. 'Monday', 'Tuesday')
            $table->time('start_time'); // Ora de începere
            $table->time('end_time'); // Ora de finalizare

            // Cheia străină care face legătura cu tabela "teachers"
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_schedules');
    }
};
