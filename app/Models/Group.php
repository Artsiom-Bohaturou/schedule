<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = ['name', 'date_start', 'date_end'];

    public function educationType()
    {
        return $this->belongsTo(GroupEducationType::class, 'education_type_id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
