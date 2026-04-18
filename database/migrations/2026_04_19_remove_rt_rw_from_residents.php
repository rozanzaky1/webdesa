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
        Schema::table('residents', function (Blueprint $table) {
            // Drop rt and rw columns if they exist
            if (Schema::hasColumn('residents', 'rt')) {
                $table->dropColumn('rt');
            }
            if (Schema::hasColumn('residents', 'rw')) {
                $table->dropColumn('rw');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // Restore columns if needed
            $table->string('rt')->nullable()->after('hamlet');
            $table->string('rw')->nullable()->after('rt');
        });
    }
};
