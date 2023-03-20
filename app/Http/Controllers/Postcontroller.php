<?php

namespace App\Http\Controllers;

use App\Http\Resources\Postresource;
use App\Http\Resources\DetailPostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $image = null;

         if ($request->file) {
             $fileName = $this ->generateRandomString();
             $extension = $request->file->extension();

             $image = $fileName. '.' .$extension;
             Storage::putFileAs('image', $request->file, $image);
         }
        $request['image'] = $image;

        $request['author'] = Auth::user()->id;

        $post = Post::create($request->all());
        return new DetailPostResource($post->loadMissing('writer:id,username'));
    }
    public function update(Request $request, $id)
    {
        $request-> validate([
            'title' => 'required|max:225',
            'news_content' => 'required'
        ]);

        $image = null;

        if ($request->file) {
            $fileName = $this ->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName. '.' .$extension;
            Storage::putFileAs('image', $request->file, $image);
        }

        // return response()->json('sudah dapat di digunakan');
        $request['image'] = $image;

        $post = Post::findOrFail($id);
        $post->update($request->all());

        // return response()->json('sudah dapat di gunakan');
        return new DetailPostResource($post->loadMissing('writer:id,username'));
    }
    public function delete($id){
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => "data successfully deleted"
        ]);
    }
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>
