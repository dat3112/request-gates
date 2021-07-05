<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('users', 'category_id'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedSmallInteger('category_id')->nullable()->index();
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('restrict');
            });
        }
    }
}
