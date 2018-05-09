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
                'consumer_key' => '',
                'consumer_secret' => '',
                'token' => '',
                'secret' => '',
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
