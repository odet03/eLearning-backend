<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'card_number', 'expiry_date'];

    /**
     * A card belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
}


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}