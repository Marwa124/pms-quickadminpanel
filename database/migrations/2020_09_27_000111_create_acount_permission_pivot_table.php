<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcountPermissionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('acount_permission', function (Blueprint $table) {
            $table->unsignedInteger('acount_id');
            $table->foreign('acount_id', 'acount_id_fk_2176503')->references('id')->on('acounts')->onDelete('cascade');
            $table->unsignedInteger('permission_id');
            $table->foreign('permission_id', 'permission_id_fk_2176503')->references('id')->on('permissions')->onDelete('cascade');
        });
    }
}
