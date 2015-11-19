<?php
  
namespace App\Http\Controllers;
  
use App\User;
use App\GiftGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
  
class UserController extends Controller{
  

    public function createUser(Request $request){
        
        $this->validate($request, [
            'name' => 'required',
            'email' => 'unique:user,email',
            'device_token' => 'required|max:255'
        ]);


        $user = User::create($request->all());
        
        if ($request->group_name) {
            GiftGroup::create(['user' => $user, 'group_name' => $group_name]);
        }

        Mail::send('emails.verify', ['user' => $user], function($message)
        {
            $message->to($user->email, $user->name)->subject('Secret Santa account verification');
        });
        
        return response()->json(['code':2, 'message':'Waiting for email verification']);
  
    }

    public function verifyUser(Request $request){
        $user = User::where('token', $request->token)->firstOrFail();
        if ($user->isVerified()) {
            return view('user_already_verified', ['user' => $user]);
        } else
            $user->verify();
            $user->save();
            return view('user_verified', ['user' => $user]);
        } 
    }
}