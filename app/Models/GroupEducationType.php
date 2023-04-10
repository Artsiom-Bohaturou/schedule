<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupEducationType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function group()
    {
        return $this->hasMany(Group::class, 'id');
    }
}
