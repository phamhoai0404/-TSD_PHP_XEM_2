<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroPcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_pcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('microCode');
            $table->string('ipAddress');
            $table->text('note')->nullable();
            $table->integer('depId')->nullable(true);
            $table->integer('lineId')->nullable(true);
            $table->boolean('isRunning')->default(false);
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
        Schema::dropIfExists('micro_pcs');
    }
}
