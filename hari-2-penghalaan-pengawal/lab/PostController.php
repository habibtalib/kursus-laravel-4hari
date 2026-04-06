<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| PostController — Hari 2
|--------------------------------------------------------------------------
| Contoh pengawal CRUD untuk catatan blog.
| Salin fail ini ke app/Http/Controllers/PostController.php
|
| Cipta pengawal ini dengan arahan:
| php artisan make:controller PostController --resource
|
*/

class PostController extends Controller
{
    /**
     * Papar senarai semua catatan.
     * URL: GET /posts
     */
    public function index()
    {
        // Hari 2: Respons ringkas
        return 'Senarai semua catatan blog';

        // Hari 3: Akan diganti dengan paparan Blade
        // $posts = Post::all();
        // return view('posts.index', compact('posts'));
    }

    /**
     * Papar borang untuk mencipta catatan baharu.
     * URL: GET /posts/create
     */
    public function create()
    {
        return 'Borang cipta catatan baharu';

        // Hari 3: Akan diganti dengan paparan Blade
        // return view('posts.create');
    }

    /**
     * Simpan catatan baharu ke pangkalan data.
     * URL: POST /posts
     */
    public function store(Request $request)
    {
        // Pengesahan data
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body'  => 'required|min:10',
        ]);

        // Simpan ke pangkalan data (Hari 3)
        // Post::create($validated);

        return 'Catatan berjaya disimpan!';
    }

    /**
     * Papar satu catatan tertentu.
     * URL: GET /posts/{id}
     */
    public function show(string $id)
    {
        return "Memaparkan catatan #{$id}";

        // Hari 3: Akan diganti
        // $post = Post::findOrFail($id);
        // return view('posts.show', compact('post'));
    }

    /**
     * Papar borang untuk mengedit catatan.
     * URL: GET /posts/{id}/edit
     */
    public function edit(string $id)
    {
        return "Borang edit catatan #{$id}";

        // Hari 3: Akan diganti
        // $post = Post::findOrFail($id);
        // return view('posts.edit', compact('post'));
    }

    /**
     * Kemas kini catatan dalam pangkalan data.
     * URL: PUT /posts/{id}
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body'  => 'required|min:10',
        ]);

        // Kemas kini dalam pangkalan data (Hari 3)
        // Post::findOrFail($id)->update($validated);

        return "Catatan #{$id} berjaya dikemas kini!";
    }

    /**
     * Padam catatan dari pangkalan data.
     * URL: DELETE /posts/{id}
     */
    public function destroy(string $id)
    {
        // Padam dari pangkalan data (Hari 3)
        // Post::destroy($id);

        return "Catatan #{$id} berjaya dipadam!";
    }
}
