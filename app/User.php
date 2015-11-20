<?php namespace App;
  
use Illuminate\Database\Eloquent\Model;
  use App\User;  	
class User extends Model
{
     
     protected $fillable = ['name', 'email'];
     
    public static function create(array $attributes = [])
    {
        $user = parent::create($attributes);
        $user->token = str_random(32);
        $user->device_token = $attributes['device_token'];
        $user->save();

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

    public function isAdmin()
    {
        return $this->giftGroup->admin()->getKey() == $this->getKey();
    }
       
}
?>