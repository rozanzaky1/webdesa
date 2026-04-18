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
        // Create Hamlets (Dusun) Table
        Schema::create('hamlets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->timestamps();
        });

        // Create Families Table
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('kk', 25)->unique()->primary()->index();
            $table->string('head_name')->nullable();
            $table->string('head_nik', 20)->nullable()->unique();
            $table->string('hamlet')->nullable();
            $table->integer('total_members')->default(0);
            $table->timestamps();
        });

        // Add foreign key to residents if column doesn't exist
        if (!Schema::hasColumn('residents', 'family_card_number')) {
            Schema::table('residents', function (Blueprint $table) {
                $table->string('family_card_number', 25)->nullable()->after('nik');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys first
        Schema::table('residents', function (Blueprint $table) {
            if (Schema::hasColumn('residents', 'family_card_number')) {
                $table->dropColumn('family_card_number');
            }
        });

        Schema::dropIfExists('families');
        Schema::dropIfExists('hamlets');
    }
};
