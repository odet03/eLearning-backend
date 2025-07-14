<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'quiz_id',
        'mark',
        'status'];

    /**
     * A progress entry belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A progress entry belongs to a lesson.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * A progress entry belongs to a quiz.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
