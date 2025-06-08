<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignToClass extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'assign_to_class';

    // Fillable fields
    protected $fillable = [
        'student_id',
        'class_id',
        'added_year',
        'added_datetime',
        'status',
        'new_old_status',
        'deactivate_date',
        'deactivate_reason',
    ];

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Define the relationship with the ClassModel model
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
