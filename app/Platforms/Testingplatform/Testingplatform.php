<?php

namespace App\Platforms\Testingplatform;


use App\Ad;
use App\Platform;
use App\Platforms\Traits\GetValidationRules;
use App\Platforms\MessageFormatterInterface;
use App\Platforms\PlatformInterface;

class Testingplatform implements PlatformInterface
{
    use GetValidationRules;

    public function getFormFields()
    {
        $formFieldsGenerator = new TestingplatformFormFieldGenerator();
        return $formFieldsGenerator->getAll();
    }

    public function publish(MessageFormatterInterface $message, Platform $platform)
    {
        // TODO: Implement publish() method.
    }

    public function getFormattedMessage()
    {
        // TODO: Implement getFormattedMessage() method.
    }

    public function unpublish(Ad $ad, Platform $platform)
    {
        // TODO: Implement unpublish() method.
    }

    public function getFormFieldsValidationRules()
    {
        // TODO: Implement getFormFieldsValidationRules() method.
    }

    public function getMessageFormatterClass(Ad $ad)
    {
        // TODO: Implement getMessageFormatterClass() method.
    }
}
