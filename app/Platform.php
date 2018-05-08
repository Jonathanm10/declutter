<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Platform
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $config
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Platform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Platform whereType($value)
 */
class Platform extends Model
{
    public $timestamps = false;

    public function getConfigAttribute($value)
    {
        return unserialize($value);
    }

    public function setConfigAttribute($value)
    {
        $this->attributes['config'] = serialize($value);
    }
}
