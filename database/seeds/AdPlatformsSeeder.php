<?php

use App\Ad;
use App\Platform;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdPlatformsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ad_platforms')->insert([
            'ad_id' => Ad::find(1)->id,
            'platform_id' => Platform::find(2)->id,
            'publication_item_id' => 1,
        ]);
    }
}
