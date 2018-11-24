<?php

namespace App\Models;

use App\Models\ThreadSubscription;
use App\Notifications\ThreadWasUpdated;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

/**
 * Class Thread
 *
 * @package App\Models
 * @property integer $id
 * @property string  $title
 * @property string  $body
 * @property Reply[] $Replies
 * @property User    $Owner
 * @property integer $user_id
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 *
 * Scopes:
 * @method static Builder Mine()
 */
class Thread extends Model
{
	use RecordsActivity;

	protected $guarded = [];

	protected $appends = ['IsSubscribed'];

	protected static function boot()
	{
		static::deleting(function ($thread) {
			$thread->replies->each->delete();
		});

		static::created(function ($thread) {
			$thread->recordActivity('created');
		});
	}

	//relations
	public function replies()
	{
		return $this->hasMany(Reply::class);
	}

	public function owner()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function channel()
	{
		return $this->belongsTo(Channel::class);
	}

	public function subscriptions()
	{
		return $this->hasMany(ThreadSubscription::class);
	}


	// functions
	public function addReply($reply)
	{
		$reply = $this->replies()->create($reply);

		$this->increment('replies_count');

		foreach ($this->subscriptions as $subscription) {

			$subscription->user->notify(new ThreadWasUpdated($this, $reply));
		}

		return $reply;

	}

	public function path()
	{
		return '/threads/' . $this->channel->name . '/' . $this->id;
	}

	public function getReplyCountAttribute()
	{
		return $this->replies->count();
	}

	public function subscribe()
	{
		$this->subscriptions()->create([
			'user_id' => auth()->id(),
		]);

		return $this;
	}

	public function unsubscribe()
	{
		$this->subscriptions()->where('user_id', auth()->id())->delete();
	}

	public function getIsSubscribedAttribute()
	{
		return $this->subscriptions()->where('user_id', auth()->id())->exists();
	}


	//scopes
	public function scopeMine(Builder $query, $user_id)
	{
		return $query->where('user_id', $user_id);
	}
}
