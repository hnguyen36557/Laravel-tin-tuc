<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\PostTag;
use Auth;
use Validator;

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
        PostTag::where('post_id',$id)->delete();
    	$post = Post::find($id);

        unlink($post->image);

        $post->delete();

    }
    public function getAddPost() {
        return view('admin.add-post');
    }
    public function postAddPost(Request $request) {
        
        $rules = [
            'title'       => 'required',
            'image'       => 'required|image',
            'description' => 'required',
            'content'     => 'required'
        ];

        $messages = [
            'title.required'       => 'Tiêu đề không được để trống',
            'image.required'       => "Hình ảnh không được để trống",
            'image.image'          => 'Chỉ được phép nhập hình ảnh',
            'description.required' => "Tóm tắt không được để trống",
            'content.required'     => 'Nội dung không được để trống'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {
            // dd('abc');
            $post = new Post;
            $post->title       = $request->input('title');
            $post->description = $request->input('description');
            $post->content     = $request->input('content');
            $post->status      = $request->input('status');
            $post->slug        = Str::slug($request->input('title') . '-' . time());
            $post->user_id     = Auth::user()->id;
            // if (count($request->input('tags')) > 0) {
            //     foreach ($request->input('tags') as $key => $tag) {
            //         $flag = Tag::where('name',$tag)->first();
            //         if (!$flag) {
            //             $tag = Tag::create([
            //                 'name' => $tag
            //             ]);

            //         }
            //     }
            // }
            // upload hình ảnh
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . $image->getClientOriginalExtension() . '.' . $image->getClientOriginalExtension();
                $path = 'upload/images/';
                $image-> move($path,$filename);
                $post->image = $path . $filename;
            }
            
            $post->save();

            if (count($request->input('tags')) > 0) {
                foreach ($request->input('tags') as $key => $tag) {
                    $flag = Tag::where('name',$tag)->first();
                    if (!$flag) {
                        $tag = Tag::create([
                            'name' => $tag
                        ]);
                        PostTag::create([
                            'post_id' => $post->id,
                            'tag_id' => $tag->id
                        ]);
                    }
                }
            }
            // PostTag::create([
            //     'post_id' => $post->id,
            //     'tag_id' => $tag->id
            // ]);
            return redirect()->to('admin');
        }
    }  
}