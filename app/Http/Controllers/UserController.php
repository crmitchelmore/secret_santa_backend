<?php
  
namespace App\Http\Controllers;
  
use App\User;
use App\GiftGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Log;
  
class UserController extends Controller {
  

    public function createUser(Request $request){

        $this->validate($request, [
                'name' => 'required',
                'device_token' => 'required|max:255'
            ]);

        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if ($user->verified) {
                //Verify device token!!!
                return response()->json(['code' => 3, 'message' => 'User already exists']);
            }
            if ($request->has('group_name')) {
                return response()->json(['code' => 2, 'message' => 'Already invited to a group']);
            }
            
            $user->update($request->all());
            $user->save();
        } else {
            $this->validate($request, [
                'email' => 'unique:users,email'
            ]);
            if (!$request->has('group_name')) {
                return response()->json(['code' => 1, 'message' => 'You haven\'t been invited to a group. Try creating one instead.']);
            }

            $user = User::create($request->all());
            
            if (strlen($request->input('group_name')) != 0) {
                $giftGroup = GiftGroup::create(['name' => $request->input('group_name')]);
                $giftGroup->admin()->save($user);
                $giftGroup->members()->associate($user);
            } 
        }


        $this->sendMail($user);
        
        return response()->json(['code' => 0, 'message' => 'Waiting for email verification']);
  
    }

    public function resendVerification(Request $request) 
    {
        $user = User::where('email', $request->input('email'))->firstOrFail();
        $this->sendMail($user);
    }
    
    public function verifyUser(Request $request)
    {
        $user = User::where('token', $request->input('token'))->firstOrFail();
        if ($user->verified) {
            return view('user_already_verified', ['user' => $user]);
        } else {
            $user->verified = true;
            $user->save();
            return view('user_verified', ['user' => $user]);
        } 
    }

    private function sendMail(User $user) 
    {
         
         Mail::send('emails.verify', ['user' => $user], function($message) use ($user)
        {
            $message->to($user->email, $user->name)->subject('Secret Santa account verification');
        });
    }
}