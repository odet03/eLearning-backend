<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question', 'options', 'correct_answer'];

    /**
     * A quiz question belongs to a quiz.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the options for the quiz question.
     * Assuming options are stored as a JSON array.
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value, true); // Decode the JSON string into an array
    }

    /**
     * Set the options for the quiz question.
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value); // Encode the array into a JSON string
    }
}