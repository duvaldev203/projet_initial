<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\APIError;


class BlogController extends Controller
{
    public function index(Request $request)
    {
        $data=Blog::simplePaginate($request->has('limit') ? $request->limit : 20);
        return response()-> json($data);
    }

    public function create (Request $request)
    {
        $this->validate($request->all() , [
            'name'=>'required',
            'blog_categorie_id'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description',
            'image',
            'blog_categorie_id'
            ]));
            $path1 = " ";
            // upload image de l'article
            if(isset($request->image)){
                $image = $request->file('image');
                if($image != null){
                    $extension = $image->getClientOriginalExtension();
                    $relativedestination = "uploads/image";
                    $destinationPath = public_path($relativedestination);
                    $safeName = "image".time() . '.' .$extension;
                    $image->move($destinationPath, $safeName);
                    $path1 = "$relativedestination/$safeName";
                }
            }
            $data['image'] = ($path1);
        $blog = Blog::create($data);    
         
        return response()-> json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) 
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
            'description',
            'image',
            'blog_categorie_id'
            ]));
            $path1 = " ";
            // upload image de l'article
            if(isset($request->image)){
                $image = $request->file('image');
                if($image != null){
                    //recuperer l'eextansion de l'image
                    $extension = $image->getClientOriginalExtension();
                    //position relative de l'image
                    $relativedestination = "uploads/image";
                    $destinationPath = public_path($relativedestination);
                    $safeName = "image".time() . '.' .$extension;
                    $image->move($destinationPath, $safeName);
                    $path1 = "$relativedestination/$safeName";
                }
            }
            $data['image'] = ($path1);

            $blog->name = $data['name'];
            $blog->description = $data['description'];
            $blog->image = $data['image'];
            $blog->blog_categorie_id = $data['blog_categorie_id'];
            $blog->update();
            return response()->json($blog);


    }

   public function find($id)
   {
     $blog = Blog::find($id);
    if (!$blog) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blog not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
     
    } 
    return response()->json($blog);

   }

   public function delete($id)
   {
    $blog = Blog::find($id);
    if (!$blog) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blog not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
     
    }
    $blog->delete();
        return response()->json();

   }

}
  

