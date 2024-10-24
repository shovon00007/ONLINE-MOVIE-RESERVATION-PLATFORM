<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show available showtimes for booking
    public function index()
    {
        $showtimes = Showtime::with('movie')->orderBy('date')->orderBy('showtime')->get();
        return view('booking.index', compact('showtimes'));
    }

    // Show the booking form for a specific showtime
    public function create($id)
    {
        $showtime = Showtime::findOrFail($id);
        return view('booking.create', compact('showtime'));
    }

    // Store the booking in the database
    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'selected_seats' => 'required|json',
            'ticket_price' => 'required|numeric',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
        ]);
    
        // Fetch the showtime by ID
        $showtime = Showtime::findOrFail($request->showtime_id);
        
        // Decode the selected seats from JSON
        $selectedSeats = json_decode($request->selected_seats);
        $numberOfSeats = count($selectedSeats);
    
        // Check if enough capacity is available
        if ($showtime->seat_capacity < $numberOfSeats) {
            return redirect()->back()->with('error', 'Not enough seats available.');
        }
    
        // Create a new booking
        Booking::create([
            'user_id' => Auth::id(),
            'showtime_id' => $request->showtime_id,
            'selected_seats' => $request->selected_seats,
            'ticket_price' => $request->ticket_price,
            'payment_status' => 'Completed',
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'movie_name' => $showtime->movie->title,
            'movie_time' => $showtime->showtime,
            'show_date' => $showtime->date,
            'total_seats' => $numberOfSeats,
            'seat_numbers' => json_encode($selectedSeats), // Store selected seats as JSON
        ]);
    
        // Decrease the seat capacity in the showtime
        $showtime->seat_capacity -= $numberOfSeats;
    
        // Log current and newly selected seats
        $currentSelectedSeats = json_decode($showtime->selected_seats) ?: [];
        \Log::info('Current Selected Seats: ', (array)$currentSelectedSeats);
        \Log::info('Newly Selected Seats: ', (array)$selectedSeats);
    
        // Remove the booked seats from the current selected seats
        foreach ($selectedSeats as $seat) {
            $key = array_search($seat, $currentSelectedSeats);
            if ($key !== false) {
                unset($currentSelectedSeats[$key]); // Remove the booked seat
            }
        }
    
        // Log the updated seats after removal
        \Log::info('Updated Selected Seats after removal: ', (array)$currentSelectedSeats);
    
        // Update the showtime with new capacity and selected seats
        $showtime->selected_seats = json_encode(array_values($currentSelectedSeats)); // Store updated selected seats as JSON
    
        // Save the updated showtime
        if (!$showtime->save()) {
            return redirect()->back()->with('error', 'Failed to update showtime. Please try again.');
        }
    
        return redirect()->route('booking.history')->with('success', 'Booking successfully created!');
    }
    

    // Show the booking confirmation page
    public function show($id)
    {
        $showtime = Showtime::findOrFail($id);
        return view('booking.show', compact('showtime'));
    }

    public function confirm(Request $request, $showtime_id)
    {
        $request->validate(['selected_seats' => 'required|json']);
        $selectedSeats = json_decode($request->selected_seats, true);
        $showtime = Showtime::with('movie')->findOrFail($showtime_id);
        $ticketPrice = $showtime->ticket_price;
        $totalAmount = count($selectedSeats) * $ticketPrice;
    
        // Get the authenticated user's name and email
        $userName = Auth::user()->name;
        $userEmail = Auth::user()->email;
    
        // Pass user name and email to the view
        return view('booking.confirm', compact('showtime', 'selectedSeats', 'totalAmount', 'userName', 'userEmail'));
    }
    

    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('showtime.movie')->get();
        return view('booking.history', compact('bookings'));
    }
public function viewBooking($id)
{
    $booking = Booking::with('showtime.movie')->findOrFail($id); // Assuming `showtime` has a relation to `movie`
    
    return view('booking.booking-details', compact('booking'));
}

}