<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingMinutesTable extends Migration
{
    public function up()
    {
        Schema::create('meeting_minutes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('attendees')->nullable();
            $table->string('location')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
