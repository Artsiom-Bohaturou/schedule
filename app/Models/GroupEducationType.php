<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupEducationType extends Model
{
    protected $fillable = ['full_name', 'abbreviated_name', 'time_type'];
    public $timestamps = false;

    public function groups()
    {
        return $this->hasMany(Group::class, 'education_type_id');
    }
}
