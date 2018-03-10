<?php

use Faker\Generator as Faker;


$factory->define(App\Feed::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'url' => 'http://feeds.feedburner.com/technologijos-visos-publikacijos?format=xml',
        'provider_url' => null
    ];
});
