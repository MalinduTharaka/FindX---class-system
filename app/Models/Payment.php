<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Table associated with the model (optional if the table name matches the model name)
    protected $table = 'payments';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'class_id',
        'student_id',
        'total',
        'paid_amount',
        'month',
    ];

    // Define the relationships
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id'); // Assuming you have a Class model
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id'); // Assuming you have a Student model
    }
}
