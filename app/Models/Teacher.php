<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = ['image', 'full_name'];

    public function department()
    {
        return $this->belongsTo(TeacherDepartment::class);
    }

    public function position()
    {
        return $this->belongsTo(TeacherPosition::class);
    }
}
