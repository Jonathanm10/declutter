<?php

namespace App\Platforms\Twitter;

use App\Platforms\PlatformInterface;

class Twitter implements PlatformInterface
{
    public function getFormFields()
    {
        $twitterFormFields = new TwitterFormFieldGenerator();
        return $twitterFormFields->getAll();
    }

    public function getFormFieldsValidationRules()
    {
        // TODO: Implement getFormFieldsValidationRules() method.
    }
}
