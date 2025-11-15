<?php

namespace App\Models;

use App\Builders\StudentBuilder;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseEloquentBuilder(StudentBuilder::class)]
class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'student_id',
        'grade_id',
        'section_id',
        'image'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->image) {
                return null;
            }
            return Storage::disk(config('filesystems.default'))->url($this->image);
        });
    }
}
