<?php

namespace App\Platforms\Traits;


trait GetValidationRules
{
    public function getFormFieldsValidationRules()
    {
        $formFields = collect($this->getFormFields());

        return $formFields->reduce(function($formRules, $field) {
            $formRules[$field['name']] = $field['validation'];
            return $formRules;
        }, []);
    }
}
