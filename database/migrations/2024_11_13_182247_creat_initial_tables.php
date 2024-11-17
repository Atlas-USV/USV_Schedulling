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
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->timestamps();
        });

        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->timestamps();
        });



        Schema::table('users', function (Blueprint $table) {
            // Adding new fields to the users table
            $table->foreignId('specialty_id')->nullable()->constrained('specialities')->onDelete('set null');
            $table->foreignId('teacher_faculty_id')->nullable()->constrained('faculties')->onDelete('set null');
        });


        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->timestamps();
        });

        //TODO user specialty

       
        
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('speciality_id')->constrained('specialities')->onDelete('cascade');
            $table->smallInteger('number');
            $table->smallInteger('study_year');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('block')->nullable();
            $table->string('short_name');
            $table->timestamps();
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('speciality_id')->constrained('specialities')->onDelete('cascade');
            $table->smallInteger('attempt')->default(1); //<- higher than 1 = reexamination
            $table->date('exam_date');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('type', ['exam', 'colocviu']);
            $table->json('other_examinators')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('year_of_study')->nullable(); // <- nullable in case when not reexamination 

            $table->index(['subject_id', 'teacher_id', 'group_id']);
            $table->timestamps();
        });

       
        Schema::create('user_group', function (Blueprint $table) {
            $table->id(); // Optional
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping columns if rolling back
            $table->dropForeign(['specialty_id']);
            $table->dropColumn('specialty_id');
            $table->dropForeign(['teacher_faculty_id']);
            $table->dropColumn('teacher_faculty_id');
        });
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['subject_id']);
        });
        Schema::dropIfExists('user_group');
       
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('specialities');
        Schema::dropIfExists('faculties');
        
        
       
       
        
        

      
    }
};
