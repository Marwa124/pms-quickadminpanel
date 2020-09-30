<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('username')->nullable();
            $table->integer('activated')->nullable();
            $table->integer('banned')->nullable();
            $table->longText('ban_reason')->nullable();
            $table->string('last_ip')->nullable();
            $table->datetime('last_login');
            $table->integer('online_time')->nullable();
            $table->string('smtp_email_type')->nullable();
            $table->string('smtp_encription')->nullable();
            $table->string('smtp_action')->nullable();
            $table->string('smtp_host_name')->nullable();
            $table->string('smtp_user_name')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_additional_flag')->nullable();
            $table->string('last_postmaster_run')->nullable();
            $table->string('media_path_slug')->nullable();
            $table->string('marketting_username')->nullable();
            $table->string('marketing_password')->nullable();
            $table->string('marketing_type')->nullable();
            $table->string('sp_username')->nullable();
            $table->string('sp_password')->nullable();
            $table->integer('vacation_balance')->nullable();
            $table->integer('vacation_counterdown')->nullable();
            $table->string('date_of_join')->nullable();
            $table->string('date_of_insurance')->nullable();
            $table->integer('vacation_verified')->nullable();
            $table->integer('role_id')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
