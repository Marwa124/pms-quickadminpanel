<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeparrtmentsTable extends Migration
{
    public function up()
    {
        Schema::create('deparrtments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department_name');
            $table->string('email')->nullable();
            $table->string('encryption')->nullable();
            $table->string('host')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('mailbox')->nullable();
            $table->integer('unread_email')->nullable();
            $table->integer('delete_email_after_import')->nullable();
            $table->string('last_postmaster_run')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
