<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassFeeHistory extends Model
{
    use HasFactory;

    // Table name (optional, Laravel uses snake_case of the class name by default)
    protected $table = 'class_fee_history'; 


    // Fillable properties
    protected $fillable = [
        'class_id',
        'old_fee',
        'new_fee',
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }
}
