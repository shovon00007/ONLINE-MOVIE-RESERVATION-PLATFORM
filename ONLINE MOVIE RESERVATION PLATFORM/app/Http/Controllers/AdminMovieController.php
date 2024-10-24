<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;
use App\Models\Movie;
use Illuminate\Http\Request;

class AdminMovieController extends Controller
{
    // List all movies for admin
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    // Show form to create a new movie
    public function create()
    {
        return view('admin.movies.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'synopsis' => 'required',
            'genre' => 'required',
            'rating' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_link' => 'nullable|url',
            'imdb_link' => 'nullable|url',
        ]);
    
        $data = $request->all();
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('movies', 'public');
        }
    
        Movie::create($data);
    
        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
    }
    
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'synopsis' => 'required',
            'genre' => 'required',
            'rating' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_link' => 'nullable|url',
            'imdb_link' => 'nullable|url',
        ]);
    
        $movie = Movie::findOrFail($id);
        $data = $request->all();
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($movie->image) {
                Storage::disk('public')->delete($movie->image);
            }
            $data['image'] = $request->file('image')->store('movies', 'public');
        }
    
        $movie->update($data);
    
        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
    }
    
    // Delete the specified movie
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
    }
    
}

