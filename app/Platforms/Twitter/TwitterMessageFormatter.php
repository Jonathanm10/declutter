<?php

namespace App\Platforms\Twitter;


use App\Ad;
use App\Platforms\MessageFormatterInterface;

class TwitterMessageFormatter implements MessageFormatterInterface
{
    protected $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function getFormattedMessage()
    {
        return sprintf(
            "%s\n%s\nPrix : %d CHF",
            $this->ad->title, $this->ad->description, $this->ad->price
        );
    }
}
