<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class channel
 *
 * @package App\Models
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Thread[] $threads
 */
class Channel extends Model
{
	// Relations
	public function Threads()
	{
		return $this->hasMany(Thread::class, 'channel_id');
	}
	
	// Functions

	public function getRouteKeyName()
	{
		return 'slug';
	}
}
