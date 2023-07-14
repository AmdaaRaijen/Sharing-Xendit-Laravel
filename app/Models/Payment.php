<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['external_id', 'email', 'status', 'product_id', 'payment_url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
