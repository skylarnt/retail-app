<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\Quantity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $message= trans('inventory.view');
        $data= Inventory::all();

        return response([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request)
    {
        $message= trans('inventory.created');
        $errormessage=trans('inventory.failed');
        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
