<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vanbans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tenvanban',100);
            $table->mediumText('duongdan');
            $table->string('loaivanban',45)->nullable();
            $table->string('captochuc',45)->nullable();
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
        Schema::dropIfExists('vanbans');
    }
}
