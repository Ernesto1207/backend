<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
    ];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_dish')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
