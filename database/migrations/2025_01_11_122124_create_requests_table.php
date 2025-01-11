<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id(); // ID-ul primar al cererii
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // ID-ul profesorului
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // ID-ul studentului
            $table->text('content'); // Conținutul cererii
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending'); // Statusul cererii
            $table->timestamps(); // Campuri pentru created_at și updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};

