<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Foreign key to movies table
            $table->time('showtime'); // Time of the show
            $table->date('date'); // Date of the show
            $table->integer('seat_capacity'); // Total number of seats available
            $table->decimal('ticket_price', 8, 2); // Price of the ticket
            $table->longText('selected_seats')->nullable(); // JSON string of selected seats
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('showtimes'); // Drop the showtimes table
    }
}
