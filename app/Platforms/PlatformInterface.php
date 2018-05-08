<?php

namespace App\Platforms;


interface PlatformInterface
{
    public function getFormFields();
    public function getFormFieldsValidationRules();
}
