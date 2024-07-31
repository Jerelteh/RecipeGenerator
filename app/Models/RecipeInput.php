<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
