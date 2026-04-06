<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| PostController API — Hari 4
|--------------------------------------------------------------------------
| Cipta pengawal ini dengan arahan:
| php artisan make:controller Api/PostController --api
|
| Salin fail ini ke app/Http/Controllers/Api/PostController.php
|
*/

class PostController extends Controller
{
    /**
     * Senarai semua catatan.
     * GET /api/posts
     *
     * Respons JSON:
     * {
     *   "data": [
     *     { "id": 1, "title": "...", "body": "...", ... },
     *     ...
     *   ]
     * }
     */
    public function index()
    {
        $posts = Post::with('user:id,name')
                     ->latest()
                     ->paginate(10);

        return response()->json([
            'status'  => 'success',
            'data'    => $posts,
        ]);
    }

    /**
     * Simpan catatan baharu.
     * POST /api/posts
     *
     * Body (JSON):
     * {
     *   "title": "Tajuk Catatan",
     *   "body": "Isi kandungan catatan..."
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'body'  => 'required|min:10',
        ]);

        // Tambah user_id jika ada pengesahan
        // $validated['user_id'] = auth()->id();
        $validated['user_id'] = 1; // Sementara untuk ujian
        $validated['slug'] = \Str::slug($validated['title']);

        $post = Post::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Catatan berjaya dicipta.',
            'data'    => $post,
        ], 201);
    }

    /**
     * Papar satu catatan.
     * GET /api/posts/{id}
     */
    public function show(string $id)
    {
        $post = Post::with('user:id,name')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $post,
        ]);
    }

    /**
     * Kemas kini catatan.
     * PUT /api/posts/{id}
     *
     * Body (JSON):
     * {
     *   "title": "Tajuk Baharu",
     *   "body": "Isi kandungan baharu..."
     * }
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|min:3|max:255',
            'body'  => 'sometimes|required|min:10',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = \Str::slug($validated['title']);
        }

        $post->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Catatan berjaya dikemas kini.',
            'data'    => $post,
        ]);
    }

    /**
     * Padam catatan.
     * DELETE /api/posts/{id}
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Catatan berjaya dipadam.',
        ]);
    }
}
