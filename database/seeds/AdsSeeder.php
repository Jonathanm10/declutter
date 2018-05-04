<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads')->insert([
            'title' => 'My testing title ad',
            'description' => 'My could be long testing description',
            'img_url' => 'https://news.nationalgeographic.com/content/dam/news/photos/000/755/75552.adapt.1900.1.jpg',
            'price' => 34.45,
        ]);
    }
}
