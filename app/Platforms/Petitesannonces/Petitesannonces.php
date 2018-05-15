<?php

namespace App\Platforms\Petitesannonces;


use App\Ad;
use App\Platform;
use App\Platforms\MessageFormatterInterface;
use App\Platforms\PlatformInterface;
use App\Platforms\Traits\GetValidationRules;

class Petitesannonces implements PlatformInterface
{
    use GetValidationRules;

    public function getFormFields() : array
    {
        $petitesannoncesFormField = new PetitesannoncesFormFieldGenerator();
        return $petitesannoncesFormField->getAll();
    }

    public function publish(MessageFormatterInterface $message, Platform $platform)
    {
        // TODO: Implement publish() method.
    }

    public function unpublish(Ad $ad, Platform $platform)
    {
        // TODO: Implement unpublish() method.
    }

    public function getMessageFormatterClass(Ad $ad)
    {
        // TODO: Implement getMessageFormatterClass() method.
    }
}
