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
        DB::statement("ALTER TABLE evaluations MODIFY COLUMN type ENUM('exam', 'colloquium', 'project', 'reexamination', 'retake') NOT NULL");
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn(['attempt']); // Replace with the name of the index to drop
        });
        // Drop an index
        // Schema::table('evaluation', function (Blueprint $table) {
        //     $table->dropIndex(['old_index_name']); // Replace with the name of the index to drop
        // });

        // Add a new index
        // Schema::table('your_table', function (Blueprint $table) {
        //     $table->index(['new_column_name']); // Replace with the column(s) for the new index
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE evaluations MODIFY COLUMN type ENUM('exam', 'colocviu') NOT NULL");
        Schema::table('evaluations', function (Blueprint $table) {
             $table->smallInteger('attempt')->default(1);
        });
    }
};
