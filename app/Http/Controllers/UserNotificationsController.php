<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return auth()->user()->unreadNotifications;
    }

	public function destroy(User $user, $notificationId)
	{
		auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
