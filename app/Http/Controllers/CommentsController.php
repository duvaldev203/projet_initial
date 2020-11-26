<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controler;
use App\Models\Comments;
use App\Models\APIError;


class CommentsController extends Controller
{
    public function index(Request $request)
    {
        $data=comments::simplePaginate($request->has('limit') ? $request->limit : 25);
        return response()-> json($data);
    }

    public function create (Request $request)
    {
        $this->validate($request->all() , [
            'name'=>'required',
            'email' => 'required|email',
            'blog_id'=>'required'
        ]);
        $data = [];
        $data = array_merge($data, $request->only([
            'name',
            'email',
            'website',
            'contend',
            'blog_id'
        ]));
        $comment = Comments::create($data);    
         
        return response()-> json($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = Comments::find($id);
        if (!$comment) 
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
            'email',
            'website',
            'contend',
            'blog_id'
            ]));
            $comment->name = $data['name'];
            $comment->email = $data['email'];
            $comment->website = $data['website'];
            $comment->contend = $data['contend'];
            $comment->blog_id = $data['blog_id'];
            $comment->update();
            return response()->json($comment);


    }

   public function find($id)
   {
     $comment = Comments::find($id);
    if (!$comment) 
    {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("comment not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);

    } 
    return response()->json($comment);

   }

    public function delete($id)
    {
        $comment = Comments::find($id);
        if (!$comment) 
        {
        $error = new APIError;
        $error-> setStatus("404");
        $error-> setCode("comment not found");
        $error-> setMessage("l'id que vous recherchez n'existe pas!!!");
        return response()-> json($error , 404);
        }
     
        $comment -> delete($id);
        return response()->json();
    }



}   