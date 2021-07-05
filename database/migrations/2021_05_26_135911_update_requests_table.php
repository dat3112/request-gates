<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('approve_id')->nullable()->index();
            $table->foreign('approve_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('requests', 'approve_id'))
        {
            Schema::table('requests', function (Blueprint $table) {
                $table->dropForeign(['approve_id']);
                $table->dropColumn(['approve_id']);
            });
        }
    }
}
