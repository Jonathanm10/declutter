<?php

namespace App\Platforms\Twitter;

use App\Platforms\GetValidationRules;
use App\Platforms\PlatformInterface;

class Twitter implements PlatformInterface
{
    use GetValidationRules;

    public function getFormFields()
    {
        $twitterFormFields = new TwitterFormFieldGenerator();
        return $twitterFormFields->getAll();
    }
}
