<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'teacher_profile_id',
        'lesson_id',
        'title_tk',
        'title_ru',
        'title_en',
        'description_tk',
        'description_ru',
        'description_en',
        'file_path',
        'file_name',
        'file_size',
        'file_extension',
        'downloads_count',
        'is_public',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'downloads_count' => 'integer',
            'is_public' => 'boolean',
            'status' => 'integer',
        ];
    }

    public function teacherProfile(): BelongsTo
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}