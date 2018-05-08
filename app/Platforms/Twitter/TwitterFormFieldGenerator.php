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
                'name' => 'TWITTER_CONSUMER_KEY',
                'type' => 'text',
                'id' => 'consumer_key',
                'validation' => '',
            ],
            [
                'label' => 'Consumer secret',
                'name' => 'TWITTER_CONSUMER_SECRET',
                'type' => 'text',
                'id' => 'consumer_secret',
                'validation' => '',
            ],
            [
                'label' => 'Access token',
                'name' => 'TWITTER_ACCESS_TOKEN',
                'type' => 'text',
                'id' => 'access_token',
                'validation' => '',
            ],
            [
                'label' => 'Access token secret',
                'name' => 'TWITTER_ACCESS_TOKEN_SECRET',
                'type' => 'text',
                'id' => 'access_token_secret',
                'validation' => '',
            ],
        ];
    }
}
