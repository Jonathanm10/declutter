<?php

namespace App\Platforms\Petitesannonces;


class PetitesannoncesFormFieldGenerator
{
    /**
     * @return array
     */
    public function getAll()
    {
        return [
            [
                'label' => 'Email',
                'name' => 'email',
                'type' => 'text',
                'id' => 'email',
                'validation' => '',
            ],
            [
                'label' => 'Password',
                'name' => 'password',
                'type' => 'password',
                'id' => 'password',
                'validation' => '',
            ],
        ];
    }
}
