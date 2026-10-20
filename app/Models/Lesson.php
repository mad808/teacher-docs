<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'name_tk',
        'name_ru',
        'name_en',
        'slug',
        'icon',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(TeacherProfile::class, 'lesson_teacher');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}