<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name_tk');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->string('type', 50)->default('university')->index();
            $table->string('city', 100)->nullable()->index();
            $table->text('address_tk')->nullable();
            $table->text('address_ru')->nullable();
            $table->text('address_en')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
            DB::statement('CREATE INDEX institutions_name_tk_trgm_idx ON institutions USING gin (name_tk gin_trgm_ops);');
            DB::statement('CREATE INDEX institutions_name_ru_trgm_idx ON institutions USING gin (name_ru gin_trgm_ops);');
            DB::statement('CREATE INDEX institutions_name_en_trgm_idx ON institutions USING gin (name_en gin_trgm_ops);');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS institutions_name_tk_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS institutions_name_ru_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS institutions_name_en_trgm_idx;');
        }
        Schema::dropIfExists('institutions');
    }
};