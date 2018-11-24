<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Reply
 *
 * @package App\Models
 * @property integer    $id
 * @property integer    $user_id
 * @property User       $Owner
 * @property string     $body
 * @property Thread     $thread
 * @property Favorite[] $favorites
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class Reply extends Model
{
	// @todo Create Favorite Trait
	use RecordsActivity;

	protected $guarded = [];

	protected $appends = ['favoritesCount', 'isFavorited'];

	//relations
	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function favorites()
	{
		return $this->morphMany('App\Models\Favorite', 'favorite');
	}

	public function favorite()
	{
		$attributes = ['user_id' => auth()->id()];

		if (!$this->favorites()->where($attributes)->exists()) {
			return $this->favorites()->create($attributes);
		}
	}

	public function unFavorite()
	{
		$attributes = ['user_id' => auth()->id()];
		$this->favorites()->get()->each->delete();

	}

	public function thread()
	{
		return $this->belongsTo(Thread::class);
	}


	// Functions
	public function isFavorited()
	{
		return $this->favorites()->where('user_id', auth()->id())->exists();
	}

	public function getFavoritesCountAttribute()
	{
		return $this->favorites->count();
	}

	public function getIsFavoritedAttribute()
	{
		return $this->isFavorited();
	}

	public function path()
	{
		return $this->thread->path() . "#reply-{$this->id}";
	}
}
