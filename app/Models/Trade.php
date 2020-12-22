<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    public static function lastPrice($id)
    {   
        $t = Trade::where('stock_id','=', $id)->
        orderby('created_at','DESC')->first(); 
        if ($t!=null) {
            return $t->price;
        }
        return 0;
    }

    public static function tradeCount($id)
    {   
        $t = Trade::where('stock_id','=', $id)->get(); 
        
        return count($t);
    }

    public static function priceMovement($id)
    {   
        $old = Trade::where('stock_id','=', $id)->
        where('created_at','<=', date('Y-m-d H:i:s' , strToTime("-1 hours")))->
        orderby('created_at','DESC')->first();
        if ($old!=null) {
            $old = $old->price;
        }
        $new = Trade::lastPrice($id);
        if ($old > $new) {
            return '<span class="down"> ▼ </span>'.round(($old - $new)/($old/100),3);
        }elseif($old == $new){
            return " = 0.000";   
        }else{
            return '<span class="up">  ▲ </span>'.(round(($old - $new)/($old/100),3)*-1);
        }
    }

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock','stock_id','id');
    }


}
