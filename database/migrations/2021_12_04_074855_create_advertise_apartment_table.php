<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiseApartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertise_apartment', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->unsignedBigInteger('apartment_id');
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');

            $table->unsignedBigInteger('advertise_id');
            $table->foreign('advertise_id')->references('id')->on('advertises')->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status'); // Pagamento accettato o no
            $table->string('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertise_apartment');
    }
}
