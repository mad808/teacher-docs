<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
            $table->string('name_tk');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('slug');
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();

            $table->unique(['institution_id', 'slug']);
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
            DB::statement('CREATE INDEX departments_name_tk_trgm_idx ON departments USING gin (name_tk gin_trgm_ops);');
            DB::statement('CREATE INDEX departments_name_ru_trgm_idx ON departments USING gin (name_ru gin_trgm_ops);');
            DB::statement('CREATE INDEX departments_name_en_trgm_idx ON departments USING gin (name_en gin_trgm_ops);');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS departments_name_tk_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS departments_name_ru_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS departments_name_en_trgm_idx;');
        }
        Schema::dropIfExists('departments');
    }
};