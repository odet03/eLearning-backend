<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lesson_id', 'course_id', 'quiz_id', 'content'];

    /**
     * A comment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A comment belongs to a lesson.
     */
    public function lessons()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * A comment belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * A comment belongs to a quiz.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}