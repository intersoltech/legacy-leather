<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [
    'user_id','order_ref','first_name','last_name','email','phone',
    'address','city','country','postal_code',
    'payment_method','currency','subtotal','shipping','total',
    'notes','status'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }
}
