<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Specify the table name

    protected $fillable = [
        'name',
        'subject_id',
        'grade_id',
        'teacher',
        'new_old_status',
        'class_fee',
    ];

    // Relationship with Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relationship with Grade
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // In Assign Model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

}
