<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Programme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programme', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36);
            $table->string('visible_name', 255);
            $table->text('description');
            $table->string('thumbnail_ref', 255);
            $table->unsignedInteger('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('programme');
    }
}
