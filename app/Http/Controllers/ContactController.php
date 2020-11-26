<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function create()
    {

    }
    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        /* reply::create($data);
        */
        Mail::to('duvaldonfack19@gmail.com')->send(new ContactMail($data));
        
        return response()->json('Votre message a ete envoyé!!!');
    }
}
