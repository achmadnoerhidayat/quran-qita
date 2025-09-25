<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;

use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            $surah->where('nama_latin', 'like', '%' . $search . '%');
        }
        $surah = $surah->paginate($limit);
        return ResponseFormated::success($surah, 'data surah berhasil ditambahkan');
    }

    public function tafsir(Request $request)
    {
        $surah = $request->input('surah_id');
        if (!isset($surah)) {
            return ResponseFormated::error(null, 'surah id wajib diisi', 422);
        }
        $response = Http::get('https://equran.id/api/v2/tafsir/' . $surah);
        if ($response->successful()) {
            $tafsir = $response->json();
            return ResponseFormated::success($tafsir['data']['tafsir'], 'data tafsir berhasil ditampilkan');
        } else {
            return ResponseFormated::error(null, 'data tafsir gagal ditampilkan', 403);
        }
    }
}
