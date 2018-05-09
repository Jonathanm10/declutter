<?php

namespace App\Platforms;


use App\Ad;

interface MessageFormatterInterface
{
    public function __construct(Ad $ad);
    public function getFormattedMessage();
}
