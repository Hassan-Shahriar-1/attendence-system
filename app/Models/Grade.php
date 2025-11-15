<?php

namespace App\Models;

use App\Policies\GradePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(GradePolicy::class)]
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
