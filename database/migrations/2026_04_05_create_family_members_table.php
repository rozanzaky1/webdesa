<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('family_card_number')->index();
            $table->string('nik')->unique();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('hamlet')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // Foreign key to families table
            $table->foreign('family_card_number')
                ->references('kk')
                ->on('families')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_members');
    }
};
