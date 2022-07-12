<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
/**
 * @OA\Schema(
 *     title="Inventory",
 *     description="Inventory model",
 *     @OA\Xml(
 *         name="Inventory"
 *     )
 * )
 */
class Inventory extends Model
{
    use HasFactory;
    protected $with=['inventoryQuantity'];
    protected $fillable=['name', 'price', 'quantity']; 
    

    

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
    

    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new inventory",
     *      example="Package One"
     * )
     *
     * @var string
     */
    private $name;

    /**
    * @OA\Property(
    *      title="price",
    *      description="Inventory price",
    *      type="number",
    *      example="20000"
    * )
    *
    * @var string
    */
   private $price;

    /**
    * @OA\Property(
    *      title="quantity",
    *      description="Inventory quantity",
    *      example="200"
    * )
    *
    * @var string
    */
   private $quantity;

   
    
}
