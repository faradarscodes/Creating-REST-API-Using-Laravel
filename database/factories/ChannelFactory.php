<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Channel::class, function (Faker $faker) {
	$name = $faker->word;
    return [
        'name' => $name,
		'slug' => $name,
    ];
});
