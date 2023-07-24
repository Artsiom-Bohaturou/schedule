<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTime extends Model
{
    protected $fillable = ['time_start', 'time_end'];
    public $timestamps = false;

    public static function getTimeRange()
    {
        return self::all()
            ->map(fn($el) => [
                'id' => $el->id,
                'duration' => "$el->time_start - $el->time_end",
                'time_start' => $el->time_start,
                'time_end' => $el->time_end,
            ]);
    }
}
