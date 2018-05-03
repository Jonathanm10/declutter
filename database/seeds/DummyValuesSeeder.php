<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adId = DB::table('ads')->insertGetId([
            'title' => 'My testing title ad',
            'description' => 'My could be long testing description',
            'img_url' => 'https://news.nationalgeographic.com/content/dam/news/photos/000/755/75552.adapt.1900.1.jpg',
            'price' => 34.45,
        ]);

        $platformId = DB::table('platforms')->insertGetId([
            'type' => 'Twitter',
        ]);

        DB::table('ad_platforms')->insert([
            'ad_id' => $adId,
            'platform_id' => $platformId,
        ]);
    }
}
