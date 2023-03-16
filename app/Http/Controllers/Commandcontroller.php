<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Commandcontroller extends Controller
{
    public function store(Request $request)
    {
        $request -> validate([
            'post_id' => 'required|exist:posts,id',
            'comment_content' => 'required',
        ]);
    }
}
