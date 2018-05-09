<?php

namespace App\Platforms;


use App\Ad;
use App\Platform;

interface PlatformInterface
{
    public function getFormFields();
    public function getFormFieldsValidationRules();
    public function publish(MessageFormatterInterface $message, Platform $platform);
    public function unpublish(Ad $ad, Platform $platform);
    public function getMessageFormatterClass(Ad $ad);
}
