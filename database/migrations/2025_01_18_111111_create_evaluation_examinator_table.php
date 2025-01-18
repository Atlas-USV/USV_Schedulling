<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationExaminatorTable extends Migration
{
    public function up()
    {
        Schema::create('evaluation_examinator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn('other_examinators');
        });
    }

    public function down()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->json('other_examinators')->nullable();
        });

        Schema::dropIfExists('evaluation_examinator');
    }
}