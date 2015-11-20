<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Log;
class Controller extends BaseController
{

	protected function loadUser($request)
	{
		$user = $request->attributes->get('user');
		$this->user = $user;
	    $this->giftGroup = $user ? $user->giftGroup() : false;
	}
}
