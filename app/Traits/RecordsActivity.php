<?php
/**
 * Created by PhpStorm.
 * User: Mehran
 * Date: 7/26/2018
 * Time: 6:24 PM
 */

namespace App\Traits;


use App\Models\Activity;
use function foo\func;

trait RecordsActivity
{

	protected static function bootRecordsActivity()
	{

		if(auth()->guest()) return;
		foreach (static::getRecordEvents() as $event) {
			static::$event(function ($model) use ($event){
				$model->recordActivity($event);
			});
		}

		static :: deleting(function ($model){
			$model->activity()->delete();
		});
	}

	protected function recordActivity($event)
	{
		$this->activity()->create([
			'user_id' => auth()->id(),
			'type'    => $this->getActivityType($event),
		]);
	}

	public function activity()
	{
		return $this->morphMany('App\Models\Activity', 'subject');
	}

	protected function getActivityType($event)
	{
		$type = strtolower((new \ReflectionClass($this))->getShortName());
		return $event . '_' . $type;
	}

	protected static function getRecordEvents()
	{
		return ['created'];
	}

}