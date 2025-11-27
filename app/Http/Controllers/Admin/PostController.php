<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PublicPost;
use GuzzleHttp\RetryMiddleware;
use PhpParser\Node\Stmt\Return_;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->cekAuth();
        $posts = Post::paginate(10);

        //append query string to pagination links
        $posts->appends(['q' => request()->q]);

        return inertia('Admin/Posts/Index', [
            'posts' => $posts,

          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->cekAuth();

        return inertia('Admin/Posts/Create', [

          ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->cekAuth();
       // Validate request including file validation
       $request->validate([
         'title' => 'required|string',
         'body' => 'required|',
         'image' => '|image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
         ]);

     // Generate initial slug from title
     $slug = strtolower(str_replace(' ', '-', $request->title));
     $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
     $originalSlug = $slug;
     $counter = 1;

     // Check if the generated slug is unique, if not, append a number
     while (Post::where('slug', $slug)->exists()) {
         $slug = $originalSlug . '-' . $counter;
         $counter++;
     }

     $body = $request->body;
     // Ambil 100 kata pertama dari body
     // Hapus tag HTML dari body
     $bodyWithoutTags = strip_tags($body);
     $words = str_word_count($bodyWithoutTags, 1);
     $excerpt = implode(' ', array_slice($words, 0, 50));

     // Tambahkan "..." jika body memiliki lebih dari 100 kata
     if (count($words) > 50) {
         $excerpt .= '...';
     }
     $today = Carbon::now()->format('Y-m-d H:i:s');


     $image = $request->file('image');
     if ($image) {
         $image = $request->file('image')->storePublicly('/images');
         // Proceed with storing or processing the uploaded file
     };

        Post::create([
            'title' => $request->title,
            'body' =>  $request->body,
            'slug' => $slug,
            'excerpt' => $excerpt,
            'image' => $image,
            'publish_at' => $today,
            'user_id' => auth()->id(),
            'status' => 'deactive',
        ]);

       //redirect
       return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $this->cekAuth();
        $post = Post::findOrFail($id);

        return inertia('Admin/Posts/Show', [
           'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->cekAuth();
        $post = Post::findOrFail($id);

        return inertia('Admin/Posts/Edit', [
           'post' => $post,

        ]);
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
        $this->cekAuth();
       // Validate request including file validation
     $request->validate([
         'title' => 'required|string',
         'body' => 'required|',
     ]);

     $post = Post::findOrFail($id); // Ambil data post yang akan diupdate

     $slug = strtolower(str_replace(' ', '-', $request->title));
     $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
     
     // Cek keunikan slug hanya jika judul berubah
     if ($post->title !== $request->title) {
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $id)->exists()) {
             $slug = $originalSlug . '-' . $counter;
             $counter++;
         }
     } else {
        $slug = $post->slug; // Pertahankan slug lama jika judul tidak berubah
     }


     $body = $request->body;

     // Ambil 50 kata pertama dari body
     $bodyWithoutTags = strip_tags($body);
     $words = str_word_count($bodyWithoutTags, 1);
     $excerpt = implode(' ', array_slice($words, 0, 50));

     // Tambahkan "..." jika body memiliki lebih dari 50 kata
     if (count($words) > 50) {
         $excerpt .= '...';
     }
     $today = Carbon::now()->format('Y-m-d H:i:s');


     $image = $request->file('image');
     $image_path = $post->image; // Pertahankan gambar lama secara default
     
     if ($image) {
         // Logika hapus gambar lama (jika ada) di sini bisa ditambahkan
         $image_path = $request->file('image')->storePublicly('/images');
     } 

        $post->update([
            'title' => $request->title,
            'body' =>  $request->body,
            'slug' => $slug,
            'excerpt' => $excerpt,
            'image' => $image_path,
            'publish_at' => $today,
            'user_id' => auth()->id(),
            // Pertahankan status lama saat update
        ]);

       //redirect
       return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->cekAuth();

        $post = Post::findOrFail($id);

        $post->delete();
        // Opsional: Logika menghapus file gambar di storage

        //redirect
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus!');
    }


    // ===============================================
    //               FUNGSI BARU (STATUS)
    // ===============================================

    /**
     * Mengubah status post menjadi 'active'.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $this->cekAuth();

        $post = Post::findOrFail($id);

        $post->update([
            'status' => 'active'
        ]);

        // redirect dengan pesan sukses
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil diaktifkan!');
    }

    /**
     * Mengubah status post menjadi 'deactive'.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $this->cekAuth();

        $post = Post::findOrFail($id);

        $post->update([
            'status' => 'deactive'
        ]);
        
        // redirect dengan pesan sukses
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dinonaktifkan!');
    }


    public function cekAuth()
    {
        if(!auth()->check()) {
            auth()->logout(); // Log out the user programmatically
            return redirect()->route('login')->with('warning', 'Anda tidak memiliki akses');
        }
    }
}