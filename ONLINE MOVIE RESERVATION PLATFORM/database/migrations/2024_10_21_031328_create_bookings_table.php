<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('showtime_id')->constrained()->onDelete('cascade');
            $table->longText('selected_seats'); // Store selected seats as JSON
            $table->decimal('ticket_price', 8, 2);
            $table->string('payment_status')->default('pending');
            $table->string('user_name');
            $table->string('user_email');
            $table->string('movie_name');
            $table->string('movie_time');
            $table->date('show_date');
            $table->integer('total_seats');
            $table->json('seat_numbers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
