<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;

class AdminShowtimeController extends Controller
{
    // List all showtimes
    public function index()
    {
        $showtimes = Showtime::all();
        return view('admin.showtimes.index', compact('showtimes'));
    }

    // Show form to create a showtime
    public function create()
    {
        $movies = Movie::all();
        return view('admin.showtimes.create', compact('movies'));
    }

    // Store a new showtime
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'showtime' => 'required',
            'date' => 'required|date',
            'seat_capacity' => 'required|integer',
            'ticket_price' => 'required|numeric',
            'selected_seats' => 'required|json',
        ]);

        // Decode selected seats from JSON
        $selectedSeats = json_decode($request->selected_seats);

        // Check if selected seats match seat capacity
        if (count($selectedSeats) !== (int) $request->seat_capacity) {
            return back()->withErrors(['seat_capacity' => 'The number of selected seats must equal the seat capacity.']);
        }

        // Create new showtime
        Showtime::create([
            'movie_id' => $request->movie_id,
            'showtime' => $request->showtime,
            'date' => $request->date,
            'seat_capacity' => $request->seat_capacity,
            'ticket_price' => $request->ticket_price,
            'selected_seats' => $request->selected_seats,
        ]);

        return redirect()->route('admin.showtimes.index')->with('status', 'Showtime created successfully!');
    }

    // Show the form to edit a showtime
    public function edit($id)
    {
        $showtime = Showtime::findOrFail($id);
        $movies = Movie::all();
        $selectedSeats = json_decode($showtime->selected_seats, true);

        return view('admin.showtimes.edit', compact('showtime', 'movies', 'selectedSeats'));
    }

    // Update a showtime
    public function update(Request $request, $id)
    {
        $showtime = Showtime::findOrFail($id);

        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'showtime' => 'required',
            'date' => 'required|date',
            'seat_capacity' => 'required|integer',
            'ticket_price' => 'required|numeric',
            'selected_seats' => 'required|json',
        ]);

        // Decode the selected seats from JSON
        $selectedSeats = json_decode($request->selected_seats);

        // Check if selected seats match the seat capacity
        if (count($selectedSeats) !== (int) $request->seat_capacity) {
            return back()->withErrors(['seat_capacity' => 'The number of selected seats must equal the seat capacity.']);
        }

        // Update showtime
        $showtime->update([
            'movie_id' => $request->movie_id,
            'showtime' => $request->showtime,
            'date' => $request->date,
            'seat_capacity' => $request->seat_capacity,
            'ticket_price' => $request->ticket_price,
            'selected_seats' => $request->selected_seats,
        ]);

        return redirect()->route('admin.showtimes.index')->with('status', 'Showtime updated successfully!');
    }

    // Delete the showtime
    public function destroy($id)
    {
        $showtime = Showtime::findOrFail($id);
        $showtime->delete();

        return redirect()->route('admin.showtimes.index')->with('success', 'Showtime deleted successfully.');
    }
}
