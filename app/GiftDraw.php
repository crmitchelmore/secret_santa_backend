<?php namespace App;
  
use Illuminate\Database\Eloquent\Model;
  
class GiftDraw extends Model
{
     
     protected $fillable = [];]

    public function giftGroup()
    {
        return $this->belongsTo('App\GiftGroup');
    }
     
}
?>