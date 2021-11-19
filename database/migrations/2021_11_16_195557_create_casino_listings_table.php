<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasinoListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casino_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('casino_id');
            $table->integer('level')->default(1);

            $table->timestamps();
            $table->index(['country_id', 'casino_id', 'level']);
            $table->unique(['country_id', 'casino_id']);

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('casino_id')->references('id')->on('casinos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casino_listings');
    }
}
