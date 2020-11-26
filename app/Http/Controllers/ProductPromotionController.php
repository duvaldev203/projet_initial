<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Contoller;
use App\Models\ProductPromotion;
use App\Models\APIError;


class ProductPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $data = ProductPromotion::simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        //
        $this->validate($request->all() , [
            'pourcentage'=>'required',
            'product_id'=>'required',
            'promotion_id'=>'required',
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'pourcentage',
            'is_promo',
            'product_id',
            'promotion_id'
            ]));
            
        $blog = ProductPromotion::create($data);    
         
        return response()-> json($blog);
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
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $productpromotion = ProductPromotion :: find($id);
        if(!$productpromotion){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas");
            return response() -> json($error, 404);
        }
        return response() -> json($productpromotion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPromotion $productPromotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $productpromotion = ProductPromotion :: find($id);
        if(!$productpromotion){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas");
            return response() -> json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
        'pourcentage',
        'is_promo',
        'product_id',
        'promotion_id'
        ]));
        $productpromotion->pourcentage = $data['pourcentage'];
        $productpromotion->is_promo = $data['is_promo'];
        $productpromotion->product_id = $data['product_id'];
        $productpromotion->promotion_id = $data['promotion_id'];
        $productpromotion->update();
        return response()->json($productpromotion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPromotion  $productPromotion
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $productpromotion = ProductPromotion :: find($id);
        if(!$productpromotion){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas");
            return response() -> json($error, 404);
        }
        $productpromotion -> delete($id);
        return response() -> json("ok");
    }
}
