<?php namespace App;
  
use Illuminate\Database\Eloquent\Model;
  
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
}
?>