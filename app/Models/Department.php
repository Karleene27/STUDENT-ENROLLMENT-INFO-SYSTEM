<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'dept_code', 'dept_name', 'chairperson'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}   