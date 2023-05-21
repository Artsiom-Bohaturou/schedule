<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = ['name', 'date_start', 'date_end', 'education_type_id'];

    public function educationType()
    {
        return $this->belongsTo(GroupEducationType::class, 'education_type_id', 'id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public static function getGroups()
    {
        return self::all()->map(fn($el) => strtotime($el->date_end) > time() ? [
            'id' => $el->id,
            'name' => $el->name,
            'date_end' => date('d.m.Y', strtotime($el->date_end)),
            'date_start' => date('d.m.Y', strtotime($el->date_start)),
            'education_type_id' => $el->education_type_id,
            'course' => ceil(abs(strtotime(date('Y-m-d')) - strtotime($el->date_start)) / (365 * 60 * 60 * 24)),
        ] : null);
    }
}
