<?php

namespace App\Platforms\Testingplatform;


use App\Platforms\PlatformInterface;

class Testingplatform implements PlatformInterface
{
    public function getFormFields()
    {
        $formFieldsGenerator = new TestingplatformFormFieldGenerator();
        return $formFieldsGenerator->getAll();
    }

    public function getFormFieldsValidationRules()
    {
        $formFieldsGenerator = new TestingplatformFormFieldGenerator();
        $formFields = collect($formFieldsGenerator->getAll());

        return $formFields->reduce(function($formRules, $field) {
            $formRules[$field['name']] = $field['validation'];
            return $formRules;
        }, []);
    }
}
