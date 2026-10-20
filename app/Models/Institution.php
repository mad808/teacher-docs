<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institution extends Model
{
    protected $fillable = [
        'name_tk',
        'name_ru',
        'name_en',
        'slug',
        'type',
        'city',
        'address_tk',
        'address_ru',
        'address_en',
        'phone',
        'website',
        'logo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function teacherProfiles(): HasMany
    {
        return $this->hasMany(TeacherProfile::class);
    }
}