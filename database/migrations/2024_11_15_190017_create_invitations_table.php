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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // Foreign key for created_by (user)
            $table->foreignId('speciality_id')->nullable()->constrained('specialities')->onDelete('set null'); // Foreign key for speciality
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('set null'); // Foreign key for semigroup
            $table->foreignId('teacher_faculty_id')->nullable()->constrained('faculties')->onDelete('set null'); // Foreign key for faculty
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
