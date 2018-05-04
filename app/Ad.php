<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'ad_platforms', 'platform_id', 'ad_id');
    }
}
