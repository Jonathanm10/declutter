<?php

namespace App\Platforms\Twitter;


class TwitterFormFieldGenerator
{
    /**
     * @return array
     */
    public function getAll()
    {
        return [
            [
                'label' => 'Consumer key',
                'name' => 'consumer_key',
                'type' => 'text',
                'id' => 'consumer_key',
                'validation' => '',
            ],
            [
                'label' => 'Consumer secret',
                'name' => 'consumer_secret',
                'type' => 'text',
                'id' => 'consumer_secret',
                'validation' => '',
            ],
            [
                'label' => 'Access token',
                'name' => 'token',
                'type' => 'text',
                'id' => 'access_token',
                'validation' => '',
            ],
            [
                'label' => 'Access token secret',
                'name' => 'secret',
                'type' => 'text',
                'id' => 'access_token_secret',
                'validation' => '',
            ],
        ];
    }
}
