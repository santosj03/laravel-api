<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParameterConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category', 100);
            $table->string('code', 100);
            $table->string('description')->nullable();
            $table->string('data_type', 50);
            $table->string('value');
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
        Schema::dropIfExists('parameter_configs');
    }
}
