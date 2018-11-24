<?php

namespace App\Http\Requests\Threads;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ThreadStoreRequest
 *
 * @package App\Http\Requests\Threads
 * @property string $title
 * @property string $body
 * @property integer $channel_id
 */
class ThreadStoreRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title'      => 'required|string',
			'body'       => 'required|string',
			'channel_id' => 'required|exists:channels,id',
		];
	}
}
