<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    // Show list of all movies
    public function index(Request $request)
    {
        // Get search term if any
        $searchTerm = $request->input('search');
        
        // Fetch movies, with optional search by title, genre, or synopsis
        $movies = Movie::when($searchTerm, function ($query, $searchTerm) {
            return $query->where('title', 'like', "%{$searchTerm}%")
                         ->orWhere('genre', 'like', "%{$searchTerm}%")
                         ->orWhere('synopsis', 'like', "%{$searchTerm}%");
        })->get();

        return view('movies.index', compact('movies', 'searchTerm'));
    }

    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.show', compact('movie'));
    }
}



