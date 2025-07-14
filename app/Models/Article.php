<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'author_id', 'published_at'];

    /**
     * An article belongs to an author (user).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * An article can be related to many courses (optional).
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_articles');
    }
}