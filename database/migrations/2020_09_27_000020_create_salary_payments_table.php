<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_amount');
            $table->string('fine_deductio');
            $table->string('payment_type');
            $table->longText('comments')->nullable();
            $table->date('paid_date');
            $table->string('deduct_from');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
