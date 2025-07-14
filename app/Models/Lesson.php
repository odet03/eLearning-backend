<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'order_number',
        'video_duration',
        'type'];

    /**
     * A lesson belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * A lesson can have many progress entries.
     */
    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

}