<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blogs;
use App\Models\APIError;

class BlogCategoryController extends Controller
{
       // Fonction pour lister les éléments de la table
    public function index(Request $req)
    {
        $data = BlogCategory::orderBy('created_at','desc')->simplePaginate($req->has('limit') ? $req->limit : 15);
            foreach($data as $dat){
                $nbblog = Blogs::select(Blogs::raw('count(*) as total'))->whereBlogCategorieId($dat->id)->first();
                $dat->nbblog=$nbblog->total;
            }
        return response()->json($data);
    }
    
    // fonction pour ajouter un élément dans la table
    public function create(Request $request)
    {
        $this->validate($request->all(), [
            'name'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description'
        ]));
        $blogcategory = BlogCategory::create($data);
        return response()->json($blogcategory);
    }

    public function update(Request $request, $id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blogcategory not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }

        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'description'
        ]));
        $blogcategory->name = $data['name'];
        $blogcategory->description = $data['description'];
        $blogcategory->update();
        return response()->json($blogcategory);
    }

    public function find($id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blogcategory not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        $blogs = Blogs::whereBlogCategorieId($blogcategory->id )-> get();
        if(!$blogs){
             $error = new APIError;
            $error->setStatus("404");
            $error->setCode("image not found");
            $error->setMessage("aucune image enregistrée!!!");
            return response()->json($error, 404);
        }
        
            foreach($blogs as $blog){
                $blog->image = url($blog->image);
            }
        
        $blogcategory->blog =$blogs;
        return response()->json($blogcategory);
    }

    public function delete($id)
    {
        $blogcategory = BlogCategory::find($id);
        if (!$blogcategory) {
            $error = new APIError;
            $error->setStatus("404");
            $error->setCode("blogcategory not found");
            $error->setMessage("l'id $id que vous rechercez n'existe pas!!!");
            return response()->json($error, 404);
        }
        
        $blogcategory->delete();
        return response()->json('ok!');
    }

}
