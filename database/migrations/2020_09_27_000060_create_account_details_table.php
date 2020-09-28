<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('account_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('company')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('locale')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('skype')->nullable();
            $table->string('language')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('present_address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender');
            $table->string('marital_status');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('passport')->nullable();
            $table->string('direction')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
