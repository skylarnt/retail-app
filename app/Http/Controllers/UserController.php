<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/***
 * @OA\Tag(
 *     name="User",
 *     description="User API Endpoints for Retail app"
 * )
 * 
 */
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        
    }
    
     /**
     * @OA\Get(
     *      path="/user/view_inventories",
     *      operationId="getInventoryListForUser",
     *      tags={"User"},
     *      security={{ "apiAuth": {} }},
     *      summary="Get list of Inventories for user",
     *      description="Returns list of Inventories for user",
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
     *              ),
     *              
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated."
     *       )
     *     )
     */

    public function index()
    {
        
        $inventoryController= new InventoryController;
        
        return $inventoryController->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
