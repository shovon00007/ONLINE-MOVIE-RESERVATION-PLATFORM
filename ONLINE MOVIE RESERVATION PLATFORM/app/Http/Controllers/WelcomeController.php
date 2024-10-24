<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $movies = Movie::all(); // Fetch all movies from the database
        return view('welcome', compact('movies'));
    }
}
