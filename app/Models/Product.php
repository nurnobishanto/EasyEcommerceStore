<?php

namespace App\Models;

use Dotlogics\Grapesjs\App\Contracts\Editable;
use Dotlogics\Grapesjs\App\Traits\EditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model  implements Editable
{
    use HasFactory,SoftDeletes,EditableTrait;
    protected $fillable = [
        'title',
        'description',
        'slug',
        'sku',
        'price',
        'regular_price',
        'quantity',
        'status',
        'is_featured',
        'created_by',
        'updated_by',
        'thumbnail',
        'video_type',
        'video_url',
        'gallery',
        'brand_id',
        'gjs_data',
    ];
    protected $casts = [
        'gallery' => 'array',
    ];

    // Define the default order
    protected $defaultOrder = [
        'created_at' => 'asc',
    ];

    public function scopeDefaultOrder($query)
    {
        foreach ($this->defaultOrder as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity', 'price','sub_total');
    }
}
