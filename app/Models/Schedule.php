<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = ['week_number', 'building', 'auditory', 'subgroup', 'date', 'date_start', 'date_end', 'group_id', 'teacher_id', 'subject_id', 'subject_type_id', 'weekday_id', 'subject_time_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function subjectType()
    {
        return $this->belongsTo(SubjectType::class);
    }

    public function weekday()
    {
        return $this->belongsTo(Weekday::class);
    }

    public function subjectTime()
    {
        return $this->belongsTo(SubjectTime::class);
    }
}
