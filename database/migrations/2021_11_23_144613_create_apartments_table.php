<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type')->nullable();
            $table->text('description');
            $table->smallInteger('mq')->nullable();
            $table->tinyInteger('n_rooms');
            $table->tinyInteger('n_beds');
            $table->tinyInteger('n_baths');
            $table->tinyInteger('n_guests');
            $table->string('pet');
            $table->string('h_checkin');
            $table->string('h_checkout');
            $table->smallInteger('price_night')->nullable();
            $table->string('image');
            $table->boolean('visibility')->default(true);
            $table->string('city');
            $table->string('street');
            $table->float('lat', 7,5);
            $table->float('long', 7,5);
            $table->string('house_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
