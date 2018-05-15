<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        DB::table('platforms')->insert([
            'type' => 'Petitesannonces',
            'config' => serialize(['username' => '', 'password' => '']),
        ]);
    }
}
