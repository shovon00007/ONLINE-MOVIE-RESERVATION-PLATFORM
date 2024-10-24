<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'synopsis',
        'genre',
        'rating',
        'release_date',
        'image',           // Add image to fillable fields
        'trailer_link',    // Add trailer link to fillable fields
        'imdb_link',       // Add IMDb link to fillable fields
    ];
    protected $casts = [
        'release_date' => 'date', // Cast to Carbon date
    ];
}

