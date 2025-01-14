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
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable()->change();
            $table->dateTime('end_time')->nullable()->change();
            // Add audited fields
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable(false)->change();
            $table->dateTime('end_time')->nullable(false)->change();

             // Drop audited fields
             $table->dropForeign(['created_by']);
             $table->dropColumn('created_by');
             $table->dropForeign(['updated_by']);
             $table->dropColumn('updated_by');
        });
    }
};
