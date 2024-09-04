<?php

namespace App\Http\Controllers;
use App\Models\Category; // Pastikan Anda mengimpor model Category di sini
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
/*     public function index()
    {
        return Category::all();
    } */

    public function index(Request $request)
    {
        // Tentukan jumlah item per halaman (misalnya 10)
        $perPage = 10;

        // Ambil kategori dengan pagination
        $categories = Category::paginate($perPage);

        // Kembalikan data ke frontend dalam format JSON, termasuk informasi pagination
        return response()->json([
            'data' => $categories->items(), // Data kategori
            'current_page' => $categories->currentPage(), // Halaman saat ini
            'last_page' => $categories->lastPage(), // Halaman terakhir
            'per_page' => $categories->perPage(), // Item per halaman
            'total' => $categories->total(), // Total item
            'prev_page_url' => $categories->previousPageUrl(), // URL halaman sebelumnya
            'next_page_url' => $categories->nextPageUrl(), // URL halaman berikutnya
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Category::create($request->all());
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Category::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Hapus kategori
        $category->delete();

        // Kembalikan respon JSON yang menunjukkan berhasil
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
