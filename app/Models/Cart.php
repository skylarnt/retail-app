<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * @OA\Schema(
 *     title="Cart",
 *     description="Cart model",
 *     @OA\Xml(
 *         name="Cart"
 *     )
 * )
 */
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


     /**
     * @OA\Property(
     *      title="inventory_id",
     *      type="number",
     *      description="Id  of the  inventory",
     *      example="28"
     * )
     *
     * @var string
     */
    private $inventory_id;

     /**
     * @OA\Property(
     *      title="quantity",
     *      type="number",
     *      description="cart quantity for  inventory",
     *      example="2"
     * )
     *
     * @var string
     */
    private $quantity;

    /**
     * @OA\Property(
     *      title="user_id",
     *      type="number",
     *      description="user Id",
     *      example="4"
     * )
     *
     * @var string
     */
    private $user_id;

     /**
     * @OA\Property(
     *      title="amount",
     *      type="number",
     *      description="Total amount",
     *      example="1000"
     * )
     *
     * @var string
     */
    private $amount;
}
