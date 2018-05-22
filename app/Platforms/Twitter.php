<?php

namespace App\Platforms;

use App\Ad;
use App\Platform;
use App\Platforms\Traits\ImageHelper;
use App\Platforms\Traits\GetFormValidationRules;
use Illuminate\Support\Facades\Storage;

class Twitter implements PlatformInterface
{
    use GetFormValidationRules;
    use ImageHelper;

    /**
     * @url https://developer.twitter.com/en/docs/media/upload-media/overview
     */
    const MAX_IMAGE_UPLOAD_SIZE = 5242880;

    const FORM_FIELDS = [
        [
            'label' => 'Consumer key',
            'name' => 'consumer_key',
            'type' => 'text',
            'id' => 'consumer_key',
            'validation' => '',
        ],
        [
            'label' => 'Consumer secret',
            'name' => 'consumer_secret',
            'type' => 'text',
            'id' => 'consumer_secret',
            'validation' => '',
        ],
        [
            'label' => 'Access token',
            'name' => 'token',
            'type' => 'text',
            'id' => 'access_token',
            'validation' => '',
        ],
        [
            'label' => 'Access token secret',
            'name' => 'secret',
            'type' => 'text',
            'id' => 'access_token_secret',
            'validation' => '',
        ],
    ];

    /**
     * @param Platform $platform
     * @return \Thujohn\Twitter\Twitter
     */
    public function authenticate(Platform $platform): \Thujohn\Twitter\Twitter
    {
        return \Thujohn\Twitter\Facades\Twitter::reconfig($platform->config);
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
        $twitter = $this->authenticate($platform);

        $this->imageUrlValidation($ad->img_url);

        $file = file_get_contents($ad->img_url);
        $name = $this->getUniqueNameFromUrl($ad->img_url);
        Storage::put($name, $file);
        $this->imageSizeValidation($name);
        Storage::delete($name);

        $uploadedMedia = $twitter->uploadMedia(['media' => $file]);

        $response = $twitter->postTweet(
            ['status' => $ad->formattedString, 'media_ids' => $uploadedMedia->media_id_string]
        );

        return $response->id;
    }

    /**
     * @param Ad $ad
     * @param Platform $platform
     * @return mixed
     */
    public function unpublish(Ad $ad, Platform $platform)
    {
        $twitter = $this->authenticate($platform);

        $tweetId = $ad->platforms()->where('platform_id', $platform->id)->first()->pivot->publication_item_id;

        return $twitter->destroyTweet($tweetId);
    }
}
