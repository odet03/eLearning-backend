<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollments extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'enrolled_at', 'completed_at', 'certificate_url', 'status'];

    /**
     * A user-course entry belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A user-course entry belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }



  /* * public function enrollInCourse($courseId)
    *{

        $card = $this->cards()->where('course_id', $courseId)->first();

        if ($card && $card->status == 'purchased') {
            $this->courses()->attach($courseId);
            $card->status = 'enrolled';
            $card->save();

            return true;
        }


    public function isEnrolledInCourse($courseId)
    {
        return $this->courses()->where('course_id', $courseId)->exists();
    }*/
}
