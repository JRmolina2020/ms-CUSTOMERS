<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
/**
* @OA\Info(
*             title="ms-customers documentation", 
*             version="1.0",
*             description="Customers ms, api laravel 10"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * List Customers
     * @OA\Get (
     *     path="api/customers/list",
     *     tags={"customers"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Rodolfo molina"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         type="string",
     *                         example="3012074828"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json(['customers' => $customers], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

       /**
     * Register customers
     * @OA\Post (
     *     path="/api/customers/register",
     *     tags={"customers"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"canela molina",
     *                     "phone":"3012094939"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="canela molina"),
     *              @OA\Property(property="phone", type="string", example="3012094939"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The name field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required','phone' => 'required', ]);
        $customers= new Customer();
        $customers->name = $request->name;
        $customers->phone = $request->phone;
        $customers->save();
        if($customers){
            return response()->json(['message' => 'customer saved successfully', 'customers' => $customers], 200);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     /**
     * Update customers
     * @OA\Put (
     *     path="/api/customers/{id}",
     *     tags={"customers"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "canela molina Editado",
     *                     "phone": "77777777"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="canela molina Editado"),
     *              @OA\Property(property="phone", type="string", example="777777777"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The name field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
    public function update(Request $request,$id)
    {
        $customers = Customer::find($id, ['id']);
        $customers->fill([
            'name' => request('name'),
            'phone' => request('phone'),
  
        ])->save();
 
        if($customers){
            return response()->json(['message' => 'customer updated successfully', 'customer' => $customers], 200);
        }
    
    }
 /**
     * Search customers list 
     * @OA\Get (
     *     path="/api/customers/search/{id}",
     *     tags={"customers"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Rodolfo molina"),
     *              @OA\Property(property="phone", type="string", example="3012074828"),
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Customer] #id"),
     *          )
     *      )
     * )
     */
    public function search($id)
    {
        $customers= Customer::find($id);
        if (!$customers) {
            return response()->json(["message" => "customer not found"], 404);
        }
        $customers->all();
        return response()->json(['message' => 'customer found', 'customers' => $customers], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      /**

     */


     /**
     * Delete customers
     * @OA\Delete (
     *     path="/api/customers/{id}",
     *     tags={"customers"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="NO CONTENT"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No se pudo realizar correctamente la operación"),
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        $customers= Customer::find($id);
        if (!$customers) {
            return response()->json(["message" => "customer not found"], 404);
        }
        $customers->delete();
        return response()->json(["message" => "customer successfully removed", 'customers' => $customers]);
    }
}
