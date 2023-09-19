<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'thumbnail',
        'slug',
        'status',
        'is_featured',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    // Define the relationship with the Admin model for the creator
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // Define the relationship with the Admin model for the updater
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
