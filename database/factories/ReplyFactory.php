<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Reply::class, function (Faker $faker) {
	/** @var \App\Models\Thread $thread */
	$thread = \App\Models\Thread::inRandomOrder()->first();
	return [
		'thread_id' => $thread->id,
		'user_id'   => $thread->user_id,
		'body'      => $faker->paragraph,
	];
});
