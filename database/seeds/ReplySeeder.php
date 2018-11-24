<?php

use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Reply::class, 50)->create()->each(function ($reply) {
        	$reply->thread->increment('replies_count');
		});
    }
}
