<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_id',
        'subtotal',
        'delivery_charge',
        'name',
        'phone',
        'delivery_zone_id',
        'address',
        'order_note',
        'status',
        'created_by',
        'updated_by',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // Generate a unique order ID with uppercase letters and numbers
            do {
                $order->order_id = 'ORD' .  Str::upper(Str::random(6)); // Adjust the length as needed
            } while (static::where('order_id', $order->order_id)->exists());
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function delivery_zone()
    {
        return $this->belongsTo(DeliveryZone::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'price','sub_total');
    }
}
