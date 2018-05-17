<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmokeTest extends TestCase
{
    /**
     * @dataProvider hostProvider
     */
    public function testUrls($url)
    {
        $response = $this->get($url);
        $response->assertStatus(200);
    }

    public function hostProvider()
    {
        return [
            ['/ads'],
            ['/ads/create'],
            ['/ads/1'],
            ['/platforms'],
            ['/platforms/1'],
        ];
    }
}
