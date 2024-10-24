<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\AdminShowtimeController;
use App\Http\Controllers\AdminSeatingArrangementController;
use App\Http\Controllers\ReviewController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

/*------------------------------------------
// All Normal Users Routes List
------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Movie Routes
    Route::get('/movies', [MoviesController::class, 'index'])->name('movies.index');
    Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('movies.show');

    // Booking Routes
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/show/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/confirm/{showtime_id}', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');
    Route::get('booking/view/{id}', [BookingController::class, 'viewBooking'])->name('booking.view');
    
    // Review Routes
    Route::post('/movies/{id}/reviews', [ReviewController::class, 'store'])->name('movies.reviews.store');
    Route::get('/movies/{id}/reviews', [ReviewController::class, 'show'])->name('movies.reviews.show');

});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    // Admin Home
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    
    // Admin Movie Management Routes
    Route::get('/admin/movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('/admin/movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/admin/movies', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    Route::get('/admin/movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');
    Route::put('/admin/movies/{id}', [AdminMovieController::class, 'update'])->name('admin.movies.update');
    Route::delete('/admin/movies/{id}', [AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');
    

    // Showtime Routes
    Route::get('/admin/showtimes', [AdminShowtimeController::class, 'index'])->name('admin.showtimes.index');
    Route::get('/admin/showtimes/create', [AdminShowtimeController::class, 'create'])->name('admin.showtimes.create');
    Route::post('/admin/showtimes', [AdminShowtimeController::class, 'store'])->name('admin.showtimes.store');
    Route::get('/admin/showtimes/{id}/edit', [AdminShowtimeController::class, 'edit'])->name('admin.showtimes.edit');
    Route::put('/admin/showtimes/{id}', [AdminShowtimeController::class, 'update'])->name('admin.showtimes.update');
    Route::delete('/admin/showtimes/{id}', [AdminShowtimeController::class, 'destroy'])->name('admin.showtimes.destroy');
    
});
/*------------------------------------------
--------------------------------------------
All Manager Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
    
    // Additional manager routes can be added here
});
