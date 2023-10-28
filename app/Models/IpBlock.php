<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpBlock extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'ip_blocks'; // Change the table name if necessary

    protected $fillable = [
        'ip_address',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
