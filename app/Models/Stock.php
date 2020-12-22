<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function trades()
    {
        return $this->hasMany('App\Models\Trade','stock_id','id');
    }

    public function lastPrice()
    {
        return Trade::lastPrice($this->id);
    }

    public function priceMovement()
    {
        return Trade::priceMovement($this->id);
    }

    public function tradeCount()
    {
        return Trade::tradeCount($this->id);
    }
}
