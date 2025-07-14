<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'rating', 'review'];

    /**
     * A rating belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A rating belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}