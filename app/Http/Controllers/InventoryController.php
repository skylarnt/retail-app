<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\Quantity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**

     *
     * @OA\Tag(
     *     name="Inventory",
     *     description="Inventory API Endpoints for Retail app"
     * )
     */
class InventoryController extends Controller
{
    
    
      /**
     * @OA\Get(
     *      path="/inventory",
     *      operationId="getInventoryList",
     *      tags={"Inventory"},
     *      summary="Get list of Inventories",
     *      description="Returns list of Inventories",
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
     *                      type="object",
     *                       @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Package One"
     *                      ),
     *                       @OA\Property(
     *                         property="price",
     *                         type="number",
     *                         example="20000"
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
     *                         property="inventory_quantity",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="18"
     *                          ),
     *                          @OA\Property(
        *                         property="inventory_id",
        *                         type="number",
        *                         example="1"
     *                          ),
     *                           @OA\Property(
        *                         property="quantity",
        *                         type="number",
        *                         example="200"
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
     *                  ),
     *                   description="bla bla bla"
     *              ),
     *              
     *          )
     *       )
     *     )
     */
    public function index()
    {
        
        $message= trans('inventory.view');
        $data= Inventory::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
    


     /**
     * @OA\Post(
     *      path="/inventory",
     *      operationId="storeInventory",
     *      tags={"Inventory"},
     *      summary="Store new inventory",
     *      description="Returns inventory data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Inventory")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Inventory created successful.",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="bolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Inventory created successfully."),
     *              @OA\Property(
*                         property="data",
*                         type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Package One"
     *                      ),
     *                       @OA\Property(
     *                         property="price",
     *                         type="number",
     *                         example="20000"
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
     *                         property="inventory_quantity",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="18"
     *                          ),
     *                          @OA\Property(
        *                         property="inventory_id",
        *                         type="number",
        *                         example="1"
     *                          ),
     *                          @OA\Property(
        *                         property="quantity",
        *                         type="number",
        *                         example="200"
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
        *                   ),
        *           ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=405,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      ),
     *       @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     * )
     */
    public function store(InventoryRequest $request)
    {
        $message= trans('inventory.created');
        $errormessage=trans('inventory.failed');
        // return $request->name;
        $createInventory = Inventory::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        
        
        if($createInventory) {
            $createInventory= $createInventory->fresh();

            $createInventoryQuantity=Quantity::create([
                'inventory_id' => $createInventory->id,
                'quantity' => $request->quantity,
            ]);

            return response([
                'status' => true,
                'message' => $message,
                'data' => $createInventory->fresh()
            ]);
        }


        return response([
            'status' => false,
            'message' => $errormessage,
            'data' => null
        ],405);

    }
    
    /**
     * @OA\Get(
     *      path="/inventory/{id}",
     *      operationId="getInventoryById",
     *      tags={"Inventory"},
     *      summary="Get Inventory information",
     *      description="Returns a single Inventory data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Inventory id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="bolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Success."),
     *              @OA\Property(
*                         property="data",
*                         type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Package One"
     *                      ),
     *                       @OA\Property(
     *                         property="price",
     *                         type="number",
     *                         example="20000"
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
     *                         property="inventory_quantity",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="18"
     *                          ),
     *                          @OA\Property(
        *                         property="inventory_id",
        *                         type="number",
        *                         example="1"
     *                          ),
     *                          @OA\Property(
        *                         property="quantity",
        *                         type="number",
        *                         example="200"
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
        *                   ),
        *           ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     * )
     */
    public function show($inventory)
    {
        
        if(!$inventory)  return response([
            'status' => false,
            'message' => trans('inventory.notFound'),
            'data' => null
        ],404);

        return response([
            'status' => true,
            'message' => trans('inventory.view'),
            'data' => $inventory
        ]);
        
        
    }
    
    
     /**
     * @OA\Put(
     *      path="/inventory/update/{id}",
     *      operationId="updateInventory",
     *      tags={"Inventory"},
     *      summary="Update existing inventory",
     *      description="Returns updated inventory data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Inventory  id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Inventory")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="bolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Inventory updated successfully."),
     *              @OA\Property(
*                         property="data",
*                         type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                      ),
     *                      @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Package One"
     *                      ),
     *                       @OA\Property(
     *                         property="price",
     *                         type="number",
     *                         example="20000"
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
     *                         property="inventory_quantity",
     *                         type="object",
     *                         @OA\Property(
        *                         property="id",
        *                         type="number",
        *                         example="18"
     *                          ),
     *                          @OA\Property(
        *                         property="inventory_id",
        *                         type="number",
        *                         example="1"
     *                          ),
     *                          @OA\Property(
        *                         property="quantity",
        *                         type="number",
        *                         example="200"
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
        *                   ),
        *           ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description=" Unprocessable Content"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(InventoryRequest $request, $id)
    {
        $inventory= Inventory::find($id);

        if(blank($inventory))   return response([
            'status' => false,
            'message' => trans('inventory.notFound'),
            'data' => null
        ],404);
       $inventory->name=$request->name;
       $inventory->price=$request->price;
       

       if($inventory->update()){
            $updateQuantity=Quantity::where('inventory_id', $inventory->id)->update(['quantity' => $request->quantity]);

            return response([
                'status' => true,
                'message' => trans('inventory.update'),
                'data' => $inventory->fresh()
            ]);
        }

        return response([
            'status' => false,
            'message' => trans('inventory.failedUpdate'),
            'data' => null
        ],500);

    }
    
    /**
     * @OA\Delete(
     *      path="/inventory/delete/{id}",
     *      operationId="deleteInventory",
     *      tags={"Inventory"},
     *      summary="Delete existing Inventory",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Inventory id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="Bolean", example="true"),
     *              @OA\Property(property="message", type="string", example="Inventory destroyed successfully."),
     *              @OA\Property(property="data", type="null", example="null")
     *              
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=405,
     *          description="Unable to delete Inventory"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        
        $inventory=Inventory::find($id);
        if(!$inventory) return response([
            'status' => false,
            'message' => trans('inventory.notFound'),
            'data' => null
        ],404);
        try {
            $inventory->delete();
            return response([
                'status' => true,
                'message' => trans('inventory.deleted'),
                'data' => null
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => trans('inventory.failedDelete'),
                'data' => null
            ],405);
        }
    }
}
// class FooResponse{}

