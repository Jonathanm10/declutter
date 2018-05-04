<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ad
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Platform[] $platforms
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $img_url
 * @property float $price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ad whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ad whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ad wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ad whereTitle($value)
 */
class Ad extends Model
{
    protected $fillable = ['title', 'description', 'img_url', 'price'];

    public $timestamps = false;

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'ad_platforms', 'platform_id', 'ad_id');
    }
}
