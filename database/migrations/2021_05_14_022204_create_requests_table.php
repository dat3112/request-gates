<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->longText('content');
            $table->date('due_date');
            $table->unsignedBigInteger('author_id')->nullable()->index();
            $table->foreign('author_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedSmallInteger('category_id')->nullable()->index();
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('assign_id')->nullable()->index();
            $table->foreign('assign_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedSmallInteger('status_id')->nullable()->index();
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedSmallInteger('priority_id')->nullable()->index();
            $table->foreign('priority_id')->references('id')->on('priorities')
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
        Schema::dropIfExists('requests');
    }
}
