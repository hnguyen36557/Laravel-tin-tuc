<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;

class AdminController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
    public function getIndex() {
    	$posts = Post::all();
    	return view('admin.index',['posts'=>$posts]);
    }
    public function deleteXoa($id) {
    	Post::find($id)->delete();
    }
    public function getAddPost() {
        return view('admin.add-post');
    }
    public function postAddPost(Request $request) {
        
        // dd($request->file('image'));

        // dd('abc');
        $post = new Post;
        $post->title       = $request->input('title');
        $post->description = $request->input('description');
        $post->content     = $request->input('content');
        $post->status      = $request->input('status');
        $post->slug        = Str::slug($request->input('title') . '-' . time());
        if (count($request->input('tags')) > 0) {
            foreach ($request->input('tags') as $key => $tag) {
                $flag = Tag::where('name',$tag)->first();
                if (!$flag) {
                    $tag = Tag::create([
                        'name' => $tag
                    ]);
                }
            }
        }
        // upload hình ảnh
        $image = $request->file('image');
        $filename = time() . $image->getClientOriginalExtension() . '.' . $image->getClientOriginalExtension();
        $image-> move('upload/images/',$filename);
    }
}
