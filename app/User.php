<?php namespace App;
  
use Illuminate\Database\Eloquent\Model;
  use App\User;  	
class User extends Model
{
     
     protected $fillable = ['name', 'email'];
     
    public function create(array $data)
    {
        $user = $this->model->create($data);

        $user->device_token = $data['device_token'];
        $user->token = str_random(32);

        $this->save();

        return $user;
    }

     public function giftGroup()
    {
        return $this->belongsTo('App\GiftGroup');
    }

	public function target()
    {
        return $this->hasOne('App\User', 'target_id');
    }

    public function targetedBy()
    {
        return $this->belongsTo('App\User', 'target_id');
    }

    public function isVerified() 
    {
    	return $this->token === 'verified';
    }

 	public function verify() 
    {
    	$this->token = 'verified';
    	$this->save();
    }
       
}
?>