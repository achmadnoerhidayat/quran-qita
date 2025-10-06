<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\HajiNews;
use Illuminate\Http\Request;

class HajiUmrohController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 25);
        $news = HajiNews::with('user');
        if ($id) {
            $news = $news->where('id', $id)->first();
            if (!$news) {
                return ResponseFormated::error(null, 'data haji umroh tidak ditemukan', 404);
            }
            return ResponseFormated::success($news, 'data haji umroh berhasil ditampilkan');
        }

        if ($title) {
            $news = $news->where('title', 'like', '%' . $title . '%');
        }

        $news = $news->paginate($limit);
        return ResponseFormated::success($news, 'data haji umroh berhasil ditampilkan');
    }
}
