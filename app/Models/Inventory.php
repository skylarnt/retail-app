<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inventory extends Model
{
    use HasFactory;
    protected $with=['inventoryQuantity'];
    protected $fillable=['name', 'price', 'quantity'];  
    protected $quantity;

    

    public function inventoryQuantity():HasOne
    {
        return $this->hasOne(Quantity::class, 'inventory_id', 'id');
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($model) { // before delete() method call this
            Quantity::where('inventory_id', $model->id)->delete();
        });
    }

    
}
