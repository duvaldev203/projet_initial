<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Comments;
use App\Models\APIError;


class BlogsController extends Controller
{
    public function index(Request $request)
    {
        $data=Blogs::simplePaginate($request->has('limit') ? $request->limit : 20);
            foreach($data as $dat){
                $dat->image = url($dat->image);
            }
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
        $blog = Blogs::create($data);    
         
        return response()-> json($blog);
    }

    public function update(Request $request, $id)
    {
        $blog = Blogs::find($id);
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
     $blog = Blogs::find($id);
    if (!$blog) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("blog not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
    } 
    //prend l'url de l'image
    $blog->image = url($blog->image);
    //compte tous les commentaires et prend le premier
    $nbComment = Comments ::select(Comments::raw('count(*) as total'))->whereBlogId($id)->first();
    $blog->nbComment=$nbComment->total;
    $data = Blogs::select('blogs.image','blogs.created_at','blog_categories.id as id_categorie','blog_categories.name','blog_categories.description')
    ->join('blog_categories','blogs.blog_categorie_id','=','blog_categories.id')
    ->where(['blog_categories.id' => $blog->blog_categorie_id])
    ->orderBy('created_at','desc')
    ->get();
        foreach($data as $dat){
            $dat->image = url($dat->image);
        }   
    $blog->blog=$data;
    $comment = Comments::whereBlogId($id)->orderBy('created_at','desc')->first();
    $blog->comment=$comment;

    return response()->json($blog);

   }

   public function delete($id)
   {
    $blog = Blogs::find($id);
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
  

