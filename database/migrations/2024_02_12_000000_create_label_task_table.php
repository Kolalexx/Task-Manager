<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('label_task', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('label_id')->nullable();
            $table->foreign('label_id')->on('labels')->references('id');

            $table->bigInteger('task_id')->nullable();
            $table->foreign('task_id')->on('tasks')->references('id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('label_task');
    }
};
