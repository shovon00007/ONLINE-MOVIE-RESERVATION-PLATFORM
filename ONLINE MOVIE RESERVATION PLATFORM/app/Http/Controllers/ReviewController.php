<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

class ReviewController extends Controller
{
    // Store or Update Review
    public function storeOrUpdate(Request $request, $movieId)
    {
        $request->validate([
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Check if the user has already reviewed the movie
        $existingReview = Review::where('movie_id', $movieId)->where('user_id', Auth::id())->first();

        if ($existingReview) {
            // Update the existing review
            $existingReview->update([
                'review' => $request->review,
                'rating' => $request->rating,
            ]);

            return redirect()->route('movies.reviews.show', $movieId)->with('success', 'Your review has been updated!');
        } else {
            // Create a new review
            Review::create([
                'user_id' => Auth::id(),
                'movie_id' => $movieId,
                'review' => $request->review,
                'rating' => $request->rating,
            ]);

            return redirect()->route('movies.reviews.show', $movieId)->with('success', 'Review submitted successfully!');
        }
    }

    // Show all reviews for a specific movie
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        $reviews = Review::where('movie_id', $id)->with('user')->get();
        $userReview = Review::where('movie_id', $id)->where('user_id', Auth::id())->first();

        return view('movies.reviews', compact('reviews', 'movie', 'userReview'));
    }
}


