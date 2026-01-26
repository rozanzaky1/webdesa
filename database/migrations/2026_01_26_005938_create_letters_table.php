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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->unique();
            $table->string('letter_type'); // Jenis surat (domisili, usaha, skck, dll)
            $table->foreignId('resident_id')->constrained('residents')->onDelete('cascade');
            $table->text('purpose')->nullable(); // Keperluan surat
            $table->json('additional_data')->nullable(); // Data tambahan sesuai jenis surat
            $table->date('letter_date');
            $table->string('status')->default('draft'); // draft, completed, printed
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
