<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

use HasFactory;

    protected $fillable = [
        'course_id',
        'title'];

    /**
     * A quiz belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * A quiz can have many questions.
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    /**
     * A quiz can have many progress entries.
     */
    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }
}