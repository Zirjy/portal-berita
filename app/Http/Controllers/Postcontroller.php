<?php

namespace App\Http\Controllers;

use App\Http\Resources\Postresource;
use App\Http\Resources\DetailPostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PharIo\Manifest\Author;

use function GuzzleHttp\Promise\all;


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
    public function store(Request $request){
        $request-> validate([
            'title' => 'required|max:225',
            'news_content' => 'required'
        ]);

        // return response()->json('sudah dapat di digunakan');
        
        $request['author'] = Auth::user()->id;

        $post = Post::create($request->all());
        return new DetailPostResource($post->loadMissing('writer:id,username'));
    }
    public function update(Request $request, $id)
    {
        $request -> validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);
        // return response()->json('Sudah Dapat Digunakan');
        
    }
}
?>
