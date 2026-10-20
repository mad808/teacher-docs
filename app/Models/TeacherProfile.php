<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeacherProfile extends Model
{
    protected $fillable = [
        'user_id',
        'institution_id',
        'department_id',
        'title_tk',
        'title_ru',
        'title_en',
        'degree_tk',
        'degree_ru',
        'degree_en',
        'experience_years',
        'bio_tk',
        'bio_ru',
        'bio_en',
        'education_center_tk',
        'education_center_ru',
        'education_center_en',
        'rating',
        'reviews_count',
        'is_verified',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'reviews_count' => 'integer',
            'is_verified' => 'boolean',
            'status' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_teacher');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}