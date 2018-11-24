<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;
use function Couchbase\basicDecoderV1;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * @param Reply $reply
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Reply $reply)
	{
		$reply->favorites()->create([
			'user_id'        => auth()->id(),
			'favorite_id'   => $reply->id,
			'favorite_type' => get_class($reply),
		]);

		return back();
	}

	public function destroy(Reply $reply)
	{
		$reply->unFavorite();
	}
}
