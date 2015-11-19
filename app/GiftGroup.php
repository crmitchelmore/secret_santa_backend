<?php namespace App;
  
use Illuminate\Database\Eloquent\Model;
use App\GiftGroup;  
use App\User;  
class GiftGroup extends Model
{
     
    protected $fillable = ['budget', 'event_name', 'event_date'];
  
    public function admin()
    {
        return $this->hasOne('App\User', 'admin_id');
    }   

    public function giftDraw()
    {
        return $this->hasOne('App\GiftDraw');
    }   

    public function members()
    {
        return $this->hasMany('App\User');
    }   

    public function isUserAdmin($user) 
    {
    	return $this->admin()->getKey() == $user->getKey();
    }

    public function performDraw()
    {
    	$membersLeft = $this->members()->shuffle();
    	
    	foreach ($this->members() as $user) {
    		$target = $membersLeft->pop();
    		if ($target->getKey() == $user->getKey()) {
    			if ($membersLeft->isEmpty()) {
    				performDraw();
    				break;
    			} else {
    				$user->target = $membersLeft->pop();
    				$membersLeft->push($target);
    			}
    		} else {
    			$user->target = $target;
    		}
    	}
    	$this->members()->save();
    }
}
?>
