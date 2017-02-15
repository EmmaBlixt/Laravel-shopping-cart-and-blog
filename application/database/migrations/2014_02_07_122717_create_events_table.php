<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('event_date');
            $table->integer('time');
            $table->string('title');
            $table->string('info');
            $table->string('location');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
