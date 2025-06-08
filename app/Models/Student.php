<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'parent_name',
        'parent_contact',
        'student_contact',
        'whatsapp_num',
        'school_name',
        'gender',
        'dob',
        'status'
    ];
}
