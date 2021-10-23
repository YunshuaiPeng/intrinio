<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityHistoricalData extends Migration
{
    public function up()
    {
        Schema::create('security_historical_data', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('security_id');
            $table->foreign('security_id')->references('id')->on('securities');

            $table->string('tag');
            $table->string('frequency');
            $table->date('date');
            $table->float('value');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('security_historical_data');
    }
}
