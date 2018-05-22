<?php

namespace App\Platforms;


use App\Ad;
use App\Platform;
use App\Platforms\Traits\ImageHelper;
use App\Platforms\Traits\GetFormValidationRules;
use Goutte;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use League\Uri\Components\Query;
use League\Uri\Parser;
use Symfony\Component\DomCrawler\Crawler;

class Petitesannonces implements PlatformInterface
{
    use GetFormValidationRules;
    use ImageHelper;

    const MAX_IMAGE_UPLOAD_SIZE = 8388608;

    const BASE_URL = 'https://www.petitesannonces.ch/my';
    const AD_URL = self::BASE_URL . '/annonce';
    const LOGIN_URL = self::BASE_URL . '/connexion/';
    const DELETE_AD_URL = self::AD_URL . '/suppression/?cids[]=';
    const CATEGORY_URL = self::AD_URL . '/insertion/?tid=23&step=form';

    const FORM_FIELDS = [
        [
            'label' => 'Email',
            'name' => 'email',
            'type' => 'text',
            'id' => 'email',
            'validation' => '',
        ],
        [
            'label' => 'Password',
            'name' => 'password',
            'type' => 'password',
            'id' => 'password',
            'validation' => '',
        ],
    ];

    /**
     * @param Platform $platform
     */
    public function authenticate(Platform $platform)
    {
        $config = $platform->config;

        $config['password'] = Crypt::decrypt($config['password']);

        /* @var $crawler Crawler */
        $crawler = Goutte::request('GET', self::LOGIN_URL);
        /* @var $form \Form */
        $form = $crawler->selectButton('Se connecter >')->form();
        Goutte::submit($form, $config);
    }

    /**
     * @return array
     */
    public function getFormFields(): array
    {
        return self::FORM_FIELDS;
    }

    /**
     * @param Ad $ad
     * @param Platform $platform
     * @return int
     * @throws \Exception
     */
    public function publish(Ad $ad, Platform $platform): int
    {
        $this->authenticate($platform);

        // Select 'Other' category
        /* @var $crawler Crawler */
        $crawler = Goutte::request('GET', self::CATEGORY_URL);

        // Add information about the add (title, description, price, ...)
        /* @var $form \Form */
        $form = $crawler->selectButton('Continuer >')->form();
        $adParameters = array_merge($form->getValues(), $ad->toArray());
        $crawler = Goutte::submit($form, $adParameters);

        $errors = [];
        $crawler->filter('.fem.fieldwarning')->each(function ($node) use (&$errors) {
            $errors[] = $node->text();
        });

        if (count($errors) > 0) {
            throw new \Exception(implode(', ', $errors));
        }

        // Get image from url
        $this->imageUrlValidation($ad->img_url);
        $file = file_get_contents($ad->img_url);
        $name = $this->getUniqueNameFromUrl($ad->img_url);
        Storage::put($name, $file);
        $this->imageSizeValidation($name);

        // Add image
        $form = $crawler->filter('#imageuploader')->first()->form();
        $form['picture'] = Storage::path($name);
        $crawler = Goutte::submit($form);

        // Remove it since we don't need it anymore
        Storage::delete($name);

        // Accept added image(s)
        $form = $crawler->selectButton('Continuer >')->form();
        $crawler = Goutte::submit($form, $form->getValues());

        // Select free plan
        $form = $crawler->selectButton('Choisir')->form();
        $crawler = Goutte::submit($form, ['classic' => 'Choisir']);

        // Confirm
        $form = $crawler->selectButton('Insérer mon annonce >')->form();
        $crawler = Goutte::submit($form);

        return $this->getPublicationItemIdFromUrl($crawler->getUri());
    }

    /**
     * @param Ad $ad
     * @param Platform $platform
     */
    public function unpublish(Ad $ad, Platform $platform)
    {
        $this->authenticate($platform);

        $publicationItemId = $ad->platforms()->where('platform_id', $platform->id)->first()->pivot->publication_item_id;

        /* @var $crawler Crawler */
        $crawler = Goutte::request('GET', self::DELETE_AD_URL . $publicationItemId);
        /* @var $form \Form */
        $form = $crawler->selectButton('Oui')->form();
        Goutte::submit($form);
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getPublicationItemIdFromUrl($url)
    {
        $parser = new Parser();
        $queryString = $parser($url)['query'];
        $query = new Query($queryString);
        return $query->getParam('cid');
    }
}
