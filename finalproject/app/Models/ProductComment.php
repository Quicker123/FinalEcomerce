<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'email',
        'message',
        'product_id'
    ];

    protected $table = 'product_comment';
}
