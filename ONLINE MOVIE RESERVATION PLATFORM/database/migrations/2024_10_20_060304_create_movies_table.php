<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('synopsis');
            $table->string('genre');
            $table->decimal('rating', 3, 1); // Rating out of 10, e.g. 8.7
            $table->date('release_date');
            $table->string('image')->nullable(); // Add image field
            $table->string('trailer_link')->nullable(); // Add trailer link
            $table->string('imdb_link')->nullable(); // Add IMDb link
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
