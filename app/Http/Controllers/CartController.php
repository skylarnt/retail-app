<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Quantity;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'user_id'=> 'required'
        ]);
        $validateUserUsingHelperFunction= validateUser($request->user_id);
        if(false == $validateUserUsingHelperFunction) return response([
            'status' => false,
            'message' => trans('cart.user'),
            'data' => null
        ],404);

        $userCarts=Cart::where('user_id', $validateUserUsingHelperFunction->id)->get();

        return response([
            'status' => true,
            'message' => trans('cart.success'),
            'data' => $userCarts->fresh()
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        $getInventory=Inventory::where('id', $request->inventory_id)->first();
        $validateUserUsingHelperFunction= validateUser($request->user_id);
        $itemAlreadyExistInCart = Cart::where([
            'inventory_id'=> $request->inventory_id,
            'user_id'=> $request->user_id,
        ])->first();

        if(false == $validateUserUsingHelperFunction) return response([
            'status' => false,
            'message' => trans('cart.user'),
            'data' => null
        ],404);
        
        if(blank($getInventory))   return response([
            'status' => false,
            'message' => trans('inventory.notFound'),
            'data' => null
        ],404);
        if($itemAlreadyExistInCart)   return response([
            'status' => false,
            'message' => trans('cart.duplicate'),
            'data' => null
        ],405);

        if($getInventory->inventoryQuantity->quantity < $request->quantity) 
        return response([
            'status' => false,
            'message' => trans('cart.quantity_error'),
            'data' => null
        ],404);
        

        // Calculate and validate inventory price with quantity.
        if((int)$getInventory->price * (int)$request->quantity != $request->amount)
        return response([
            'status' => false,
            'message' => trans('cart.price_error'),
            'data' => null
        ],405);

        $deductQuantity= Quantity::where('inventory_id', $request->inventory_id)->first();
        $deductQuantity->quantity -= $request->quantity;
        $deductQuantity->save();

        $addInventoryToCart= Cart::create([
            'inventory_id' => $request->inventory_id,
            'user_id' => $validateUserUsingHelperFunction->id,
            'quantity' => $request->quantity,
            'amount' => $request->amount
        ]);

        if($addInventoryToCart)  return response([
            'status' => true,
            'message' => trans('cart.added'),
            'data' => $addInventoryToCart->fresh()
        ]);

        return response([
            'status' => false,
            'message' => trans('cart.failed'),
            'data' => null
        ],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
