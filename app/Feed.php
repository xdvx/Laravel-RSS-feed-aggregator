<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

/**
 * Class Feed
 * @package App
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $provider_url
 */
class Feed extends Model
{

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
