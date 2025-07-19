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
        'video_duration'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

}