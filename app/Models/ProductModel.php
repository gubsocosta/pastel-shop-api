<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends BaseModel
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'photo'];
}
