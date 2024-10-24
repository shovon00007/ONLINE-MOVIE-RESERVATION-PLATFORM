<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'showtime',
        'date',
        'seat_capacity',
        'ticket_price',
        'selected_seats',
    ];

    // Define the relationship with the Movie model
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    protected $casts = [
        'date' => 'date',
    ];
}
