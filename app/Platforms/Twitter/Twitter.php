<?php

namespace App\Platforms\Twitter;

use App\Ad;
use App\Platform;
use App\Platforms\Traits\GetMimeTypeValidation;
use App\Platforms\Traits\GetValidationRules;
use App\Platforms\PlatformInterface;

class Twitter implements PlatformInterface
{
    use GetValidationRules;
    use GetMimeTypeValidation;

    public function authenticate(Platform $platform): \Thujohn\Twitter\Twitter
    {
        return \Thujohn\Twitter\Facades\Twitter::reconfig($platform->config);
    }

    public function getFormFields(): array
    {
        $twitterFormFields = new TwitterFormFieldGenerator();
        return $twitterFormFields->getAll();
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
        $uploadedMedia = $twitter->uploadMedia(['media' => $file]);

        $response = $twitter->postTweet(
            ['status' => $ad->formattedString, 'media_ids' => $uploadedMedia->media_id_string]
        );

        return $response->id;
    }

    public function unpublish(Ad $ad, Platform $platform)
    {
        $twitter = $this->authenticate($platform);

        $tweetId = $ad->platforms()->where('platform_id', $platform->id)->first()->pivot->publication_item_id;

        return $twitter->destroyTweet($tweetId);
    }
}
