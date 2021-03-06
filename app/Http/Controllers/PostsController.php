<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Models\Post;
use App\Models\Post as Post;
//use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$posts = Post::all();
        //$posts = Post::where('id',2)->get();
        // https://laravel.com/docs/4.2/database
        //$posts = DB::select("SELECT * FROM Posts");
        //$posts = Post::orderBy('title','asc')->take(1)->get();
        //$posts = Post::orderBy('title','asc')->get();
        $posts = Post::orderBy('id','desc')->paginate(5);
        return view('posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')){
            // Get filename with extention
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get Just Filename
            $fileName = pathinfo($request->file('cover_image')->getClientOriginalName(), PATHINFO_FILENAME);
            // Get Just Extention
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            // File Name to Store
            $fileNameToStore = $fileName."_".time().".".$extention;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $posts = Post::find($id);
        return view('posts.show',['posts'=>$posts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $posts = Post::find($id);

        // Check for correct user
        if(auth()->user()->id !== $posts->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        return view('posts.edit',['posts'=>$posts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')){
            // Get filename with extention
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get Just Filename
            $fileName = pathinfo($request->file('cover_image')->getClientOriginalName(), PATHINFO_FILENAME);
            // Get Just Extention
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            // File Name to Store
            $fileNameToStore = $fileName."_".time().".".$extention;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            if($post->cover_image != 'noimage.jpg'){
                Storage::delete('public/cover_images/'.$post->cover_image);
            }
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        // Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
