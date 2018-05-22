<?php

namespace App\Platforms\Traits;


use App\Platform;
use App\Platforms\PlatformInterface;

trait GetHelperClassFromPlatform
{
    protected function getHelperClassFromPlatform(Platform $platform) : PlatformInterface
    {
        $platformType = $platform->type;
        $class = "App\Platforms\\$platformType";

        return new $class();
    }
}
