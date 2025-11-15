<?php

namespace App\Models;

use App\Policies\SectionPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(SectionPolicy::class)]
class Section extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'grade_section');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}
