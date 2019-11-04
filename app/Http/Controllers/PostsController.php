<?php

namespace App\Http\Controllers;
use App\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function __construct()
    {
 
    }

    public function getAll(Request $request)
    {
        $cur_page = $request->page;
 
        $per_page = $request->per_page;
 
        $offset = ($cur_page-1) * $per_page;
 
        $sortCol = "id";
        $sortDir = "asc";
 
        if($request->sort != "" && $sort = explode("|", $request->sort)) {
            $sortCol = $sort[0];
            $sortDir = $sort[1];
        }
 
        $query = Post::limit($per_page)->offset($offset)->orderBy($sortCol, $sortDir);
 
        if($request->filter) {
            $query->where('title', 'like', "%$request->filter%");
        }
 
        $rows = $query->get();
 
        if($request->filter) {
            $total = Post::where('title', 'like', "%$request->filter%")->count();
        } else {
            $total = Post::count();
        }
 
        $last_page = ceil($total / $per_page);
 
        if($cur_page == 1) {
            $prev_page_url = null;
 
            if($total > $per_page) {
                $next_page_url = url('posts/all') . '?page=2';
            } else {
                $next_page_url = null;
            }
        } else if($cur_page > 1 && $cur_page < $last_page) {
            $next_page_url = url('posts/all') . '?page=' . ($cur_page + 1);
            $prev_page_url = url('posts/all') . '?page=' . ($cur_page - 1);
        } else {
            $next_page_url = null;
            $prev_page_url = url('posts/all') . '?page=' . ($cur_page - 1);
        }
 
        if(count($rows)) {
            return response()->json(['links' => ['pagination' =>
                [
                    'total' => $total,
                    'per_page' => $per_page,
                    'current_page' => $cur_page,
                    'last_page' => $last_page,
                    'next_page_url' => $next_page_url,
                    'prev_page_url' => $prev_page_url,
                    'from' => $rows[0]->id,
                    'to' => $rows[$rows->count() - 1]->id
                ]
            ],
                'data' => $rows]);
        } else {
            return response()->json(['links' => ['pagination' =>
                [
                    'total' => 0,
                    'per_page' => $per_page,
                    'current_page' => 0,
                    'last_page' => null,
                    'next_page_url' => null,
                    'prev_page_url' => null,
                    'from' => null,
                    'to' => null
                ]
            ],
                'data' => []]);
        }
    }
 
    public function store(Request $request)
    {
        $post = new Post();
 
        $post->title = $request->title;
 
        $post->body = $request->body;
 
        $post->photo = $this->uploadFile($request);
 
        $post->save();
 
        return response()->json(['msg' => "Post created successfully!"]);
    }
 
    public function update(Request $request)
    {
        $post = Post::find($request->id);
 
        $post->title = $request->title;
 
        $post->body = $request->body;
 
        if($request->file('photo') != null) {
            $post->photo = $this->uploadFile($request);
        }
 
        $post->save();
 
        return response()->json(['msg' => "Post updated successfully!"]);
    }
 
    function view(Request $request)
    {
        if(!$request->id) {
            return;
        }
 
        $post = Post::find($request->id);
 
        $post->photo = !empty($post->photo) && file_exists(public_path('uploads/' . $post->photo))? url('uploads/' . $post->photo) : "";
 
        return response()->json(['data' => $post]);
    }
 
    function delete(Request $request)
    {
        if(!$request->id) {
            return;
        }
 
        $post = Post::find($request->id);
 
        if($post->photo != "" && file_exists(public_path('uploads/' . $post->photo))) {
            @unlink(public_path('uploads/' . $post->photo));
        }
 
        $post->delete();
 
        return response()->json(['msg' => "Post deleted successfully!"]);
    }
 
    function uploadFile($request) {
 
        try {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $image->move($destinationPath, $name);
            return $name;
        } catch (\Exception $ex) {
            return '';
        }
    }
}
