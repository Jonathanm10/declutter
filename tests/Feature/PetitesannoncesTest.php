<?php

namespace Tests\Feature;

use App\Ad;
use App\Platform;
use App\Platforms\Petitesannonces\Petitesannonces;
use App\Platforms\PlatformInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PetitesannoncesTest extends TestCase
{
    use DatabaseTransactions;

    public function testImageTooBig()
    {
        $ad = Ad::create([
            'title' => 'Testing ads title',
            'description' => 'The legal term public domain refers to works whose exclusive intellectual property rights have expired,[1] have been forfeited,[2] have been expressly waived, or are inapplicable.[3] For example, the works of Shakespeare and Beethoven, and most early silent films are in the public ',
            'img_url' => 'https://upload.wikimedia.org/wikipedia/commons/3/3d/LARGE_elevation.jpg', // 14 mo image
            'price' => 34.34,
        ]);

        $petitesannonces = new Petitesannonces();
        $platform = Platform::find(2);

        try {
            $petitesannonces->publish($ad, $platform);
        } catch (\Exception $e) {
            $this->assertEquals('La taille du fichier ne doit pas excéder 8 Mo', $e->getMessage());
        }

        $this->fail('Exception should have been raised');
    }
}
