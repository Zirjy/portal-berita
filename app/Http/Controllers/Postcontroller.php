<?php

namespace App\Http\Controllers;

use App\Http\Resources\Postresource;
use App\Http\Resources\DetailPostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class Postcontroller extends Controller
{
    public function index(){
        $post = Post::all();
        // return response()->json(['data' => $post]);
        return Postresource::collection($post);
    }

    public function show($id){
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new DetailPostResource($post);
    }
}
?>
