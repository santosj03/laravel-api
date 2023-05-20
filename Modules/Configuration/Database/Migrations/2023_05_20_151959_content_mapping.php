<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContentMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_mapping', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 100);
            $table->text('error_message');
            $table->integer('error_status');
            $table->text('sms')->nullable();
            $table->text('email_subject')->nullable();
            $table->longText('email_body')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_mapping');
    }
}
