<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
  protected $fillable = [
    'user_id','order_ref','order_number','first_name','last_name','email','phone',
    'address','city','country','postal_code',
    'payment_method','currency','subtotal','shipping','total',
    'notes','status',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function items(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }

  public function payments(): HasMany
  {
    return $this->hasMany(Payment::class);
  }

  /**
   * Get the latest payment for this order
   */
  public function latestPayment()
  {
    return $this->hasOne(Payment::class)->latestOfMany();
  }

  /**
   * Get successful payment for this order
   */
  public function successfulPayment()
  {
    return $this->hasOne(Payment::class)->where('status', 'completed');
  }
}
