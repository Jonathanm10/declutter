<?php

namespace App\Platforms\Twitter;

use App\Ad;
use App\Platform;
use App\Platforms\Traits\GetValidationRules;
use App\Platforms\MessageFormatterInterface;
use App\Platforms\PlatformInterface;

class Twitter implements PlatformInterface
{
    use GetValidationRules;

    public function authenticate(Platform $platform) : \Thujohn\Twitter\Twitter
    {
        return \Thujohn\Twitter\Facades\Twitter::reconfig($platform->config);
    }

    public function getFormFields() : array
    {
        $twitterFormFields = new TwitterFormFieldGenerator();
        return $twitterFormFields->getAll();
    }

    public function publish(MessageFormatterInterface $message, Platform $platform)
    {
        $twitter = $this->authenticate($platform);

        return $twitter->postTweet(
            ['status' => $message->getFormattedMessage(), 'format' => 'json']
        );
    }

    public function unpublish(Ad $ad, Platform $platform)
    {
        $twitter = $this->authenticate($platform);

        $tweetId = $ad->platforms()->where('platform_id', $platform->id)->first()->pivot->publication_item_id;

        return $twitter->destroyTweet($tweetId);
    }

    public function getMessageFormatterClass(Ad $ad)
    {
        return new TwitterMessageFormatter($ad);
    }
}
