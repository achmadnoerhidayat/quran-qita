<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 20);

        $kategori = Category::with('products');
        if ($id) {
            $kategori = $kategori->find($id);
            if (!$kategori) {
                return ResponseFormated::error(null, 'data kategori tidak ditemukan', 404);
            }
            return ResponseFormated::success($kategori, 'data kategori berhasil ditampilkan');
        }
        if ($title) {
            $kategori = $kategori->where('title', 'like', '%' . $title . '%');
        }
        $kategori = $kategori->orderBy('title', 'asc')->paginate($limit);
        return ResponseFormated::success($kategori, 'data kategori berhasil ditampilkan');
    }
}
