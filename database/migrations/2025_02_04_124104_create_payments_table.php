<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade'); // Assuming you have a 'classes' table
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Assuming you have a 'students' table
            $table->decimal('total', 8, 2); // Total amount for the payment
            $table->decimal('paid_amount', 8, 2); // Amount paid by the student
            $table->string('month')->nullable(); // The month for which the payment is made
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
