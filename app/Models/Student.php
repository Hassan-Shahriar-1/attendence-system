<?php

namespace App\Models;

use App\Models\Attendance;
use App\Builders\StudentBuilder;
use App\Observers\StudentObserver;
use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;

#[UseEloquentBuilder(StudentBuilder::class)]
#[ObservedBy(StudentObserver::class)]
#[UseFactory(StudentFactory::class)]
class Student extends Model
{
    use SoftDeletes, HasFactory;

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

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
