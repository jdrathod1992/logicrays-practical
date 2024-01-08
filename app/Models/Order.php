<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relation\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['timestamp', 'placed', 'total_price', 'total_qty'];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
