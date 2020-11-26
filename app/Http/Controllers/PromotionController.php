<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\APIError;
use\App\Http\controllers\Contoller;
use App\Models\Promotion;


class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $data = Promotion::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'name'=>'required',
            'date_debut'=>'required',
            'date_fin'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description',
            'date_debut',
            'date_fin'
            ]));

        $promotion = Promotion::create($data);    
         
        return response()-> json($promotion);
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
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $promotion = Promotion :: find($id);
        if(!$promotion){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas");
            return response() -> json($error, 404);
        }
        return response() -> json($promotion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion :: find($id);
        if(!$promotion){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas");
            return response() -> json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
        'name',
        'description',
        'date_debut',
        'date_fin'
        ]));
        $promotion->name = $data['name'];
        $promotion->description = $data['description'];
        $promotion->date_debut = $data['date_debut'];
        $promotion->date_fin = $data['date_fin'];
        $promotion->update();
        return response()->json($promotion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $promotion = Promotion :: find($id);
        if(!$promotion){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas");
            return response() -> json($error, 404);
        }
        $promotion -> delete($id);
        return response() -> json("ok");
    }
}
