<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
	{
		$userID = $request->header('userdID');
		if (is_int($userID)){
	    	$this->user = App\User::findOrFail($userID);
	    	\View::share('user', $this->user);
	    	$this->giftGroup = $this->user->giftGroup();
	    } else {
	    	$this->user = false;
	    	$this->giftGroup = false;
	    }
	}
}
