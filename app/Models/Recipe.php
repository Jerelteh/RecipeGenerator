<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'calories',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inputs()
    {
        return $this->hasOne(RecipeInput::class);
    }
}
