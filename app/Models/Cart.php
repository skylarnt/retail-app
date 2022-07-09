<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=['inventory_id', 'user_id', 'quantity', 'amount'];
    protected $guarded=[];
    protected $with=['user', 'inventory'];


    public function user():BelongsTo
    {
       return $this->belongsTo(User::class);
    }

    public function inventory():BelongsTo
    {
       return $this->belongsTo(Inventory::class);
    }
}
