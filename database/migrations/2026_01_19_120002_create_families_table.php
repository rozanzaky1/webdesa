<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('kk')->unique();
            $table->string('head_name');
            $table->string('head_nik')->nullable();
            $table->string('hamlet')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('total_members')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('families');
    }
};
