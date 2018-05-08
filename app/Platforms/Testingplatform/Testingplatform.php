<?php

namespace App\Platforms\Testingplatform;


use App\Platforms\GetValidationRules;
use App\Platforms\PlatformInterface;

class Testingplatform implements PlatformInterface
{
    use GetValidationRules;

    public function getFormFields()
    {
        $formFieldsGenerator = new TestingplatformFormFieldGenerator();
        return $formFieldsGenerator->getAll();
    }
}
