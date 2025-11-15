<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'grade_id');
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'grade_section');
    }
}
