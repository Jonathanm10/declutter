<?php

namespace Tests\Unit;

use App\Platforms\Petitesannonces\Petitesannonces;
use Tests\TestCase;

class PetitesannoncesTest extends TestCase
{
    /**
     * @return void
     * @dataProvider testingValuesProvider
     */
    public function testGetPublicationItemIdFromUrl($url)
    {
        $petitesannonces = new Petitesannonces();
        $cid = 4376813;
        $extractedCid = $petitesannonces->getPublicationItemIdFromUrl($url);
        $this->assertEquals($cid, $extractedCid);
    }

    public function testingValuesProvider()
    {
        return [
            ['https://www.petitesannonces.ch/my/annonce/?cid=4376813'],
            ['https://www.petitesannonces.ch/my/annonce/?param=abc&cid=4376813'],
            ['https://www.petitesannonces.ch/my/annonce/?par=de&dk=2&cid=4376813'],
            ['https://www.petitesannonces.ch/my/annonce/while/testing?cid=4376813'],
        ];
    }
}
