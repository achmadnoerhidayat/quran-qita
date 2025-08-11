<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseFormated;

class SurahController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $search = $request->input('search');
        $limit = $request->input('limit', 25);
        if ($id) {
            $surah = Surah::with('ayat')->where('id', $id)->first();
            if (!$surah) {
                return ResponseFormated::error(null, 'data surah tidak ditemukan', 404);
            }
            return ResponseFormated::success($surah, 'data surah berhasil ditambahkan');
        }
        $surah = Surah::with('ayat');
        if ($search) {
            $surah->where('nama', 'like', '%' . $search . '%');
        }
        $surah = $surah->paginate($limit);
        return ResponseFormated::success($surah, 'data surah berhasil ditambahkan');
    }
}
