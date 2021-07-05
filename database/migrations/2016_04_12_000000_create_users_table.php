<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->string('phone', 10);
            $table->tinyInteger('age');
            $table->tinyInteger('gender');
            $table->string('avatar', 255);
            $table->unsignedSmallInteger('department_id')->nullable()->index();
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedSmallInteger('category_id')->nullable()->index();
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedSmallInteger('role_id')->nullable()->index();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
