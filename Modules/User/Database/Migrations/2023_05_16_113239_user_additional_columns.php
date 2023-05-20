<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAdditionalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_access_status_id')->nullable();
            $table->integer('login_attempts')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->datetime('locked_until')->nullable();

            $table->foreign('user_access_status_id')->references('id')->on('user_access_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_access_status_id');
            $table->dropColumn('login_attempts');
            $table->dropColumn('last_login_at');
            $table->dropColumn('locked_until');
        });
    }
}
