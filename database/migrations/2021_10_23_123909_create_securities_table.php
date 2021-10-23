<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecuritiesTable extends Migration
{
    public function up()
    {
        Schema::create('securities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('reference_id')->unique();
            $table->string('company_id')->unique();
            $table->string('stock_exchange_id')->unique();
            $table->string('name')->unique();
            $table->string('ticker')->unique();
            $table->string('code');
            $table->string('currency');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('securities');
    }
}
