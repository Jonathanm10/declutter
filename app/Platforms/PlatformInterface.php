<?php

namespace App\Platforms;


use App\Ad;
use App\Platform;

interface PlatformInterface
{
    public function getFormFields();
    public function getFormFieldsValidationRules();
    public function publish(Ad $ad, Platform $platform) : int;
    public function unpublish(Ad $ad, Platform $platform);
}
