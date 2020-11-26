<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\APIError;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $data = Categories::orderBy('created_at','asc')->simplePaginate($request->has('limit') ? $request->limit : 20);
            foreach($data as $dat){
                $nbblog = Product::select(Product::raw('count(*) as total'))->whereBlogCategorieId($dat->id)->first();
                $dat->nbblog=$nbblog->total;
            }
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
            'description'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description'
            ]));
            
        $categories = Categories::create($data);    
         
        return response()-> json($categories);
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
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $categorie = Categories::find($id);
        if(!$categorie)
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("Categorie not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response() -> json($error, 404);
        }
        
        return response() -> json($categorie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $categorie = Categories::find($id);
        if (!$categorie) 
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("comment not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response()-> json($error , 404);
                
        }
            $data = [];
            $data = array_merge($data, $request->only([
            'name',
            'description'
            ]));
            $categorie->name = $data['name'];
            $categorie->description = $data['description'];
        
            return response()->json($categorie);
        }    
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $categorie = Categories ::find($id);
        if (!$categorie) 
        {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("comment not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
        }
     
        $categorie -> delete($id);
        return response()->json();
    }
}
 