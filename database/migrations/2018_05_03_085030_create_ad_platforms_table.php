<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_platforms', function (Blueprint $table) {
            $table->unsignedInteger('ad_id');
            $table->unsignedInteger('platform_id');
            $table->string('publication_item_id');
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->unique(['ad_id', 'platform_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_platforms');
    }
}
