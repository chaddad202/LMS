<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progress_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('course_id')->references('id') ->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id') ->on('users')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id') ->on('quizzes')->onDelete('cascade');
            $table->string('complation_status')->nullable();
            $table->date('start_date');
            $table->date('complation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_students');
    }
};
