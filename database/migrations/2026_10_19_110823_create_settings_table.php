<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name_tk')->default('ProTeachers');
            $table->string('site_name_ru')->default('ProTeachers');
            $table->string('site_name_en')->default('ProTeachers');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('address_tk')->nullable();
            $table->text('address_ru')->nullable();
            $table->text('address_en')->nullable();
            $table->string('phone_1', 50)->nullable();
            $table->string('phone_2', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('imo')->nullable();
            $table->string('whatsapp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};