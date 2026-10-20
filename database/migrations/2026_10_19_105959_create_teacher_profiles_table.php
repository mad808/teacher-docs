<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();

            $table->string('title_tk')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();

            $table->string('degree_tk')->nullable();
            $table->string('degree_ru')->nullable();
            $table->string('degree_en')->nullable();

            $table->unsignedSmallInteger('experience_years')->default(0)->index();

            $table->text('bio_tk')->nullable();
            $table->text('bio_ru')->nullable();
            $table->text('bio_en')->nullable();

            $table->string('education_center_tk')->nullable();
            $table->string('education_center_ru')->nullable();
            $table->string('education_center_en')->nullable();

            $table->decimal('rating', 3, 2)->default(0.00)->index();
            $table->unsignedInteger('reviews_count')->default(0);
            $table->boolean('is_verified')->default(false)->index();
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
            DB::statement('CREATE INDEX tp_bio_tk_trgm_idx ON teacher_profiles USING gin (bio_tk gin_trgm_ops);');
            DB::statement('CREATE INDEX tp_bio_ru_trgm_idx ON teacher_profiles USING gin (bio_ru gin_trgm_ops);');
            DB::statement('CREATE INDEX tp_bio_en_trgm_idx ON teacher_profiles USING gin (bio_en gin_trgm_ops);');
            DB::statement('CREATE INDEX tp_title_tk_trgm_idx ON teacher_profiles USING gin (title_tk gin_trgm_ops);');
            DB::statement('CREATE INDEX tp_title_ru_trgm_idx ON teacher_profiles USING gin (title_ru gin_trgm_ops);');
            DB::statement('CREATE INDEX tp_title_en_trgm_idx ON teacher_profiles USING gin (title_en gin_trgm_ops);');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS tp_bio_tk_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS tp_bio_ru_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS tp_bio_en_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS tp_title_tk_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS tp_title_ru_trgm_idx;');
            DB::statement('DROP INDEX IF EXISTS tp_title_en_trgm_idx;');
        }
        Schema::dropIfExists('teacher_profiles');
    }
};