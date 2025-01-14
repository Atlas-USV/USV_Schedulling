<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGradeToEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('evaluations', function (Blueprint $table) {
        $table->dropColumn('grade');
    });
}

public function down()
{
    Schema::table('evaluations', function (Blueprint $table) {
        $table->addColumn('double', 'grade'); // Înlocuiește 'column_type' cu tipul coloanei originale
    });
}

}
