<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;

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
}
