<?php

namespace App\Models;

use App\Models\Mesa;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'mesa_id',
        'user_id',
        'estado',
    ];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'pedido_dish')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
