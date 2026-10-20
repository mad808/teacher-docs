<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name_tk');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
            DB::statement('CREATE INDEX lessons_name_tk_trgm_idx ON lessons USING gin (name_tk gin_trgm_ops);');
            DB::statement('CREATE INDEX lessons_name_ru_trgm_idx ON lessons USING gin (name_ru gin_trgm_ops);');
            DB::statement('CREATE INDEX lessons_name_en_trgm_idx ON lessons USING gin (name_en gin_trgm_ops);');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS lessons_name_tk_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS lessons_name_ru_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS lessons_name_en_trgm_idx;');
        }
        Schema::dropIfExists('lessons');
    }
};