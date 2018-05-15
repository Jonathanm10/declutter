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
                'label' => 'User name',
                'name' => 'username',
                'type' => 'text',
                'id' => 'username',
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
