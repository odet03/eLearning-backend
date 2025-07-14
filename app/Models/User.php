<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'email',
        'password',
        'firstName',       // إضافة حقل الاسم الأول
        'lastName',        // إضافة حقل الاسم الأخير
        'phoneNumber',     // إضافة حقل رقم الهاتف
        'profilePicture',  // إضافة حقل صورة الملف الشخصي
        'role',        // إضافة حقل نوع المستخدم (طالب / مدرب)
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lessons');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    public function cards()
    {
        return $this->hasMany(Card::class);
    }

}