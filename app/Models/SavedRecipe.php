<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipe_id'
    ];

    protected $table = 'saved_recipes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
