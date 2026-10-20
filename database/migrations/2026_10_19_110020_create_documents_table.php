<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_profile_id')->constrained('teacher_profiles')->cascadeOnDelete();
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->nullOnDelete();

            $table->string('title_tk');
            $table->string('title_ru');
            $table->string('title_en');

            $table->text('description_tk')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();

            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size');
            $table->string('file_extension', 10)->index();
            $table->unsignedInteger('downloads_count')->default(0)->index();
            $table->boolean('is_public')->default(true)->index();
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();

            $table->index(['teacher_profile_id', 'is_public', 'status']);
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
            DB::statement('CREATE INDEX documents_title_tk_trgm_idx ON documents USING gin (title_tk gin_trgm_ops);');
            DB::statement('CREATE INDEX documents_title_ru_trgm_idx ON documents USING gin (title_ru gin_trgm_ops);');
            DB::statement('CREATE INDEX documents_title_en_trgm_idx ON documents USING gin (title_en gin_trgm_ops);');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS documents_title_tk_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS documents_title_ru_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS documents_title_en_trgm_idx;');
        }
        Schema::dropIfExists('documents');
    }
};