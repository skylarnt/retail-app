<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Inventory request",
 *      description="Inventory  request body data",
 *      type="object",
 *      required={"name", "price", "quantity"}
 * )
 */
class InventoryRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new inventory",
     *      example="A nice inventory"
     * )
     *
     * @var string
     */
    

    /**
     * @OA\Property(
     *      title="price",
     *      description="2000",
     *      example="A nice inventory price"
     * )
     *
     * @var string
     */
    

    /**
     * @OA\Property(
     *      title="quantity",
     *      description="A  quantity for inventory",
     *      example="A nice inventory quantity"
     * )
     *
     * @var string
     */
    

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'quantity' => 'required'
        ];
    }
}
