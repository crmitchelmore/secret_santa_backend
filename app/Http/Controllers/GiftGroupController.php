<?php
  
namespace App\Http\Controllers;
  
use App\User;
use App\GiftGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
  
class GiftGroupController extends Controller{
  

    public function performDraw(Request $request){
        $this->loadUser($request);
        
        $this->giftGroup->performDraw();
        $this->sendDrawFinishedEmails($this->giftGroup->members());
        return response()->json($this->giftGroup->with('members')->get());
    }

    public function index(Request $request){
        $this->loadUser($request);
        //return name of group, and list of members
        //Filter target if not admin
        return response()->json($this->giftGroup->with('members')->get());
    }

    public function resendEmail(Request $request){
        $this->loadUser($request);
        $target = User::findOrFail($request->input('target_id'));
        if ($target->getKey() == $user->getKey() || $user->isAdmin()){
            sendDrawFinishedEmails([$target]);    
        }
    }

    public function addUser(Request $request){
        $this->loadUser($request);

        $this->validate($request, [
                'name' => 'required',
                'email' => 'unique:users,email'
            ]);

        
        $invited = User::create($request->all());

        $user = $this->user;
        $invited->giftGroup = $user->giftGroup;
        Mail::send('emails.invite', ['user' => $user, 'invited' => $invited], function($message) use ($invited, $user)
        {
            $message->to($invited->email, $invited->name)->subject($user->name . ' has invited to you to Secret Santa');
        });

        
        
        return response()->json(['code' => 0, 'message' => 'User Invited']);
  
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