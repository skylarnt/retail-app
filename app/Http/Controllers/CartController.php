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
     * @OA\Post(
     *      path="/user/cart/view",
     *      operationId="viewInventoryToCart",
     *      tags={"User"},
     *      security={{ "apiAuth": {} }},
     *      summary="View  cart ",
     *      description="View cart",
     *       @OA\RequestBody(
     *          required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="bolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Success."),
     *              @OA\Property(
     *                  type="array",
     *                  property="data",
     *                  @OA\Items(
     * 
     *                      @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                      ),
     *                       @OA\Property(
     *                         property="inventory_id",
     *                         type="number",
     *                         example="28"
     *                      ),
     *                      @OA\Property(
     *                         property="user_id",
     *                         type="number",
     *                         example="4"
     *                      ),
     *                      @OA\Property(
     *                         property="quantity",
     *                         type="number",
     *                         example="4"
     *                      ),
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      ),
     *                      @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      ),
     *                       @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="4"
     *                          ),
     *                           @OA\Property(
        *                         property="first_name",
        *                         type="string",
        *                         example="Olamilekan"
     *                          ),
     *                           @OA\Property(
        *                         property="last_name",
        *                         type="string",
        *                         example="Adeniyi"
     *                          ),
     *                           @OA\Property(
        *                         property="email",
        *                         type="string",
        *                         example="mailer@gmail2.com"
     *                          ),
     *                          @OA\Property(
        *                         property="user_type",
        *                         type="string",
        *                         example="user"
     *                          ),
     *                          @OA\Property(
        *                         property="email_verified_at",
        *                         type="null",
        *                         example="null"
     *                          ),
     *                          @OA\Property(
        *                         property="created_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                      @OA\Property(
        *                         property="updated_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
     *                      ),
     *                      @OA\Property(
     *                         property="inventory",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="28"
     *                          ),
     *                           @OA\Property(
        *                         property="name",
        *                         type="string",
        *                         example="Odun package2"
     *                          ),
     *                           @OA\Property(
        *                         property="price",
        *                         type="number",
        *                         example="1000"
     *                          ),
     *                          @OA\Property(
        *                         property="created_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                      @OA\Property(
        *                         property="updated_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                        @OA\Property(
     *                              property="inventory_quantity",
     *                              type="object",
        *                         @OA\Property(
            *                         property="id",
            *                         type="number",
            *                         example="12"
        *                          ),
     *                           @OA\Property(
        *                         property="inventory_id",
        *                         type="number",
        *                         example="28"
     *                          ),
     *                           @OA\Property(
        *                         property="quantity",
        *                         type="number",
        *                         example="28"
     *                          ),
     *                          @OA\Property(
        *                         property="created_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                      @OA\Property(
        *                         property="updated_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
                                
     *                      ),

     *                      ),
     *                  ),
     *              
     *                      
     *              ),
     *              
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated."
     *       ),
     *         @OA\Response(
     *          response=404,
     *          description="Resouce not found."
     *       ),
     *     )
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
     * @OA\Post(
     *      path="/user/cart/add",
     *      operationId="storeInventoryToCart",
     *      tags={"User"},
     *      security={{ "apiAuth": {} }},
     *      summary="Store Inventory to cart ",
     *      description="Store Inventory to cart",
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="inventory_id", type="bolean", example="28"),
     *              @OA\Property(property="quantity", type="bolean", example="2"),
     *              @OA\Property(property="user_id", type="bolean", example="4"),
     *              @OA\Property(property="amount", type="bolean", example="2000")
     *              
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *             
     *              @OA\Property(
     *                  type="object",
     *                  property="data",
     *                       @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                      ),
     *                       @OA\Property(
     *                         property="inventory_id",
     *                         type="number",
     *                         example="28"
     *                      ),
     *                      @OA\Property(
     *                         property="user_id",
     *                         type="number",
     *                         example="4"
     *                      ),
     *                      @OA\Property(
     *                         property="quantity",
     *                         type="number",
     *                         example="4"
     *                      ),
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      ),
     *                      @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2022-07-10T19:16:29.000000Z"
     *                      ),
     *                       @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="4"
     *                          ),
     *                           @OA\Property(
        *                         property="first_name",
        *                         type="string",
        *                         example="Olamilekan"
     *                          ),
     *                           @OA\Property(
        *                         property="last_name",
        *                         type="string",
        *                         example="Adeniyi"
     *                          ),
     *                           @OA\Property(
        *                         property="email",
        *                         type="string",
        *                         example="mailer@gmail2.com"
     *                          ),
     *                          @OA\Property(
        *                         property="user_type",
        *                         type="string",
        *                         example="user"
     *                          ),
     *                          @OA\Property(
        *                         property="email_verified_at",
        *                         type="null",
        *                         example="null"
     *                          ),
     *                          @OA\Property(
        *                         property="created_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                      @OA\Property(
        *                         property="updated_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
     *                      ),
     *                      @OA\Property(
     *                         property="inventory",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="28"
     *                          ),
     *                           @OA\Property(
        *                         property="name",
        *                         type="string",
        *                         example="Odun package2"
     *                          ),
     *                           @OA\Property(
        *                         property="price",
        *                         type="number",
        *                         example="1000"
     *                          ),
     *                          @OA\Property(
        *                         property="created_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                      @OA\Property(
        *                         property="updated_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                        @OA\Property(
     *                              property="inventory_quantity",
     *                              type="object",
        *                         @OA\Property(
            *                         property="id",
            *                         type="number",
            *                         example="12"
        *                          ),
     *                           @OA\Property(
        *                         property="inventory_id",
        *                         type="number",
        *                         example="28"
     *                          ),
     *                           @OA\Property(
        *                         property="quantity",
        *                         type="number",
        *                         example="28"
     *                          ),
     *                          @OA\Property(
        *                         property="created_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
        *                      @OA\Property(
        *                         property="updated_at",
        *                         type="string",
        *                         example="2022-07-10T19:16:29.000000Z"
        *                      ),
                                
     *                      ),

     *                      ),
     *                      
     *              ),
     *              
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated."
     *       ),
     *         @OA\Response(
     *          response=404,
     *          description="Resouce not found."
     *       ),
     *        @OA\Response(
     *          response=500,
     *          description="Internal server error."
     *       ),
     *         @OA\Response(
     *          response=405,
     *          description="Bad method."
     *       )
     *     )
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
        ],405);
        

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
