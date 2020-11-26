<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\APIError;
use\App\Http\controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $data = Product ::simplePaginate($request->has('limit') ? $request->limit : 15);
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
            'categories_id'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'price',
            'description',
            'imageD',
            'imageG',
            'imageH',
            'imageB',
            'categories_id'
            ]));
            $path1 = " ";
            // upload image de l'article
            if(isset($request->imageD)){
                $imageD = $request->file('imageD');
                if($imageD != null){
                    $extension = $imageD->getClientOriginalExtension();
                    $relativedestination = "uploads/imageD";
                    $destinationPath = public_path($relativedestination);
                    $safeName = "imageD".time() . '.' .$extension;
                    $imageD->move($destinationPath, $safeName);
                    $path1 = "$relativedestination/$safeName";
                }
            }
            $data['imageD'] = ($path1);

            $path2 = " ";
            // upload image de l'article
            if(isset($request->imageG)){
                $imageG = $request->file('imageG');
                if($imageG != null){
                    $extension = $imageG->getClientOriginalExtension();
                    $relativedestination = "uploads/imageG";
                    $destinationPath = public_path($relativedestination);
                    $safeName = "imageG".time() . '.' .$extension;
                    $imageG->move($destinationPath, $safeName);
                    $path2 = "$relativedestination/$safeName";
                }
            }
            $data['imageG'] = ($path2);
            
            $path3 = " ";
            // upload image de l'article
            if(isset($request->imageH)){
                $imageH = $request->file('imageH');
                if($imageH != null){
                    $extension = $imageH->getClientOriginalExtension();
                    $relativedestination = "uploads/imageH";
                    $destinationPath = public_path($relativedestination);
                    $safeName = "imageH".time() . '.' .$extension;
                    $imageH->move($destinationPath, $safeName);
                    $path3 = "$relativedestination/$safeName";
                }
            }
            $data['imageH'] = ($path3); 

            $path4 = " ";
            // upload image de l'article
            if(isset($request->imageB)){
                $imageB = $request->file('imageB');
                if($imageB != null){
                    $extension = $imageB->getClientOriginalExtension();
                    $relativedestination = "uploads/imageB";
                    $destinationPath = public_path($relativedestination);
                    $safeName = "imageB".time() . '.' .$extension;
                    $imageB->move($destinationPath, $safeName);
                    $path4 = "$relativedestination/$safeName";
                }
            }
            $data['imageB'] = ($path4); 
        $product = product::create($data);    
         
        return response()-> json($product);
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $product = Product :: find($id);
        if(!$product)
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response()-> json($error , 404);
        }

        $product->image = url($product->image);
        $data = Product::select('products.name','products.created_at','categories.id as id_categorie','categories.imageD',
        'categories.imageG','categories.imageH','categories.imageB','categories.price','categories.description')
        ->join('categories','blogs.categorie_id','=','categories.id')
        ->where(['categories.id' => $blog->categorie_id])
        ->get();
            foreach($data as $dat){
                $dat->image = url($dat->image);
            }   
        $product->product=$data;

        return response() -> json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product :: find($id);
        if(!$product)
        {
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
            return response()-> json($error , 404);
        }
        
        $data = [];
        $data = array_merge($data, $request->only([
        'name',
        'price',
        'description',
        'imageD',
        'imageG',
        'imageH',
        'imageB',
        'categories_id'
        ]));

            $path1 = " ";
        // upload image de l'article
        if(isset($request->imageD)){
            $imageD = $request->file('imageD');
            if($imageD != null){
                $extension = $imageD->getClientOriginalExtension();
                $relativedestination = "uploads/imageD";
                $destinationPath = public_path($relativedestination);
                $safeName = "imageD".time() . '.' .$extension;
                $imageD->move($destinationPath, $safeName);
                $path1 = "$relativedestination/$safeName";
            }
        }
            
        $path2 = " ";
        // upload image de l'article
        if(isset($request->imageG)){
            $imageG = $request->file('imageG');
            if($imageG != null){
                $extension = $imageG->getClientOriginalExtension();
                $relativedestination = "uploads/imageG";
                $destinationPath = public_path($relativedestination);
                $safeName = "imageG".time() . '.' .$extension;
                $imageG->move($destinationPath, $safeName);
                $path2 = "$relativedestination/$safeName";
            }
        }

        $path3 = " ";
        // upload image de l'article
        if(isset($request->imageH)){
        $imageH = $request->file('imageH');
            if($imageH != null){
                $extension = $imageH->getClientOriginalExtension();
                $relativedestination = "uploads/imageH";
                $destinationPath = public_path($relativedestination);
                $safeName = "imageH".time() . '.' .$extension;
                $imageH->move($destinationPath, $safeName);
                $path3 = "$relativedestination/$safeName";
            }
        }

        $path4 = " ";
        // upload image de l'article
        if(isset($request->imageB)){
            $imageB = $request->file('imageB');
            if($imageB != null){
                $extension = $imageB->getClientOriginalExtension();
                $relativedestination = "uploads/imageB";
                $destinationPath = public_path($relativedestination);
                $safeName = "imageB".time() . '.' .$extension;
                $imageB->move($destinationPath, $safeName);
                $path4 = "$relativedestination/$safeName";
            }
        }
        $data['imageD'] = ($path1);
        $data['imageG'] = ($path2);
        $data['imageH'] = ($path3);
        $data['imageB'] = ($path4);

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->imageD = $data['imageD'];
        $product->imageD = $data['imageG'];
        $product->imageD = $data['imageH'];
        $product->imageD = $data['imageB'];
        $product->categories_id = $data['categories_id'];
        $product->update();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product = product ::find($id);
        if(!$product){
            $error = new APIError;
            $error-> setStatus("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
        }
        $product -> delete($id);
        return response() -> json('ok');
    }
}
