<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = [
        'user_id',
        'showtime_id',
        'selected_seats',
        'ticket_price',
        'payment_status',
        'user_name',
        'user_email',
        'movie_name',
        'movie_time',
        'show_date',
        'total_seats',
        'seat_numbers',
    ];
    
        // Define the relationship with the Movie model
        public function movie()
        {
            return $this->belongsTo(Movie::class);
        }
    
        // Function to calculate available seats
        public function availableSeats()
        {
            // Logic to calculate available seats
            $bookedSeatsCount = Booking::where('showtime_id', $this->id)->count(); // Example logic
            return $this->seat_capacity - $bookedSeatsCount;
        }
    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with Showtime
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
    protected $casts = [
        'show_date' => 'datetime', // This ensures it's a Carbon instance
    ];
}
