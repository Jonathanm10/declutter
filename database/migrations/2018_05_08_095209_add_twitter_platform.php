<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwitterPlatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('platforms')->insert([
            'type' => 'Twitter',
            'config' => serialize([
                'TWITTER_CONSUMER_KEY' => '',
                'TWITTER_CONSUMER_SECRET' => '',
                'TWITTER_ACCESS_TOKEN' => '',
                'TWITTER_ACCESS_TOKEN_SECRET' => '',
            ]),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('platforms')->where(['type' => 'Twitter'])->delete();
    }
}
