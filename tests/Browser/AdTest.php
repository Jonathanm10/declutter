<?php

namespace Tests\Browser;

use App\Ad;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AdTest extends DuskTestCase
{
    protected $uniqueId;
    protected $testingValues;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->uniqueId = uniqid();
        $this->testingValues = [
            'title' => 'Testing title ' . $this->uniqueId,
            'description' => 'Testing description',
            'img_url' => 'https://www.testingurl.com/testingimage.jpg',
            'price' => 35.45,
        ];
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testAddNewAd()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/ads')
                ->clickLink('Ajouter')
                ->type('title', 'Testing title ' . $this->uniqueId)
                ->type('description', 'Testing description')
                ->type('img_url', 'https://www.testingurl.com')
                ->type('price', 35.45)
                ->press('Create')
                ->assertSee('Testing title ' . $this->uniqueId);
        });

        if ($ad = Ad::whereTitle('Testing title ' . $this->uniqueId)->first()) {
            $ad->delete();
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessfulEditAd()
    {
        $ad = Ad::create($this->testingValues);

        $this->browse(function (Browser $browser) use ($ad) {
            $browser->visit('/ads/' . $ad->id)
                ->type('price', 343.34)
                ->press('Edit')
                ->assertSee('343.34');
        });

        if ($ad = Ad::whereTitle('Testing title ' . $this->uniqueId)->first()) {
            $ad->delete();
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testUnsuccessfulEditAd()
    {
        $ad = Ad::create($this->testingValues);

        $this->browse(function (Browser $browser) use ($ad) {
            $browser->visit('/ads/' . $ad->id)
                ->type('price', 'abc')
                ->press('Edit')
                ->assertSee('Le champ price doit contenir un nombre');
        });

        if ($ad = Ad::whereTitle('Testing title ' . $this->uniqueId)->first()) {
            $ad->delete();
        }
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testDeleteAd()
    {
        $ad = Ad::create($this->testingValues);

        $this->browse(function (Browser $browser) use ($ad) {
            $browser->visit('/ads/' . $ad->id . '/delete')
                ->assertDontSee('Testing title ' . $this->uniqueId);
        });

        if ($ad = Ad::whereTitle('Testing title ' . $this->uniqueId)->first()) {
            $ad->delete();
        }
    }
}
