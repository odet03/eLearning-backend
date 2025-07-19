<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'status',
        'teacher_id',
        'category_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
