<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::table('requests')->update(['sender_id' => DB::raw('IF(student_id IS NOT NULL, student_id, teacher_id)')]);
}

public function down()
{
    // Lăsăm gol pentru că nu trebuie să inversăm această operație
}
};
