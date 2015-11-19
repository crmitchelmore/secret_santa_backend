<?php
  
namespace App\Http\Controllers;
  
use App\User;
use App\GiftGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
  
class GiftGroupController extends Controller{
  

    public function performDraw(Request $request){
  
        if ($this->giftGroup->isUserAdmin($this->user)){
            $this->giftGroup->performDraw();
            $this->sendDrawFinishedEmails($this->giftGroup->members());
            return response()->json($this->giftGroup->with('members')->get());
        } else {
            //WTF
        }  
    }

    public function index(Request $request){
        //return name of group, and list of members
        //Filter target if not admin
        return response()->json($this->giftGroup->with('members')->get());
    }

    public function resendEmail(Request $request){
        $target = User::findOrFail($request->user_id);
        if ($this->giftGroup->isUserAdmin($this->user)|| $target->getKey() == $user->getKey()){
            sendDrawFinishedEmails([$target]);    
        }
    }

    private function sendDrawFinishedEmails($members) 
    {
        foreach ($members as $$user) {
            Mail::send('emails.draw', ['user' => $user], function($message)
            {
                $message->to($user->email, $user->name)->subject('Secret Santa name draw finished');
            });
        }
    }
}