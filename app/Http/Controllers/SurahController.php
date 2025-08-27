<?php

namespace App\Http\Controllers;

use App\Models\Surah;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseFormated;
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
            $response = Http::get('https://equran.id/api/v2/tafsir/' . $surah->id);
            if ($response->successful()) {
                $tafsir = $response->json();
                $surah->tafsir = $tafsir['data']['tafsir'];
            }
            return ResponseFormated::success($surah, 'data surah berhasil ditambahkan');
        }
        $surah = Surah::with('ayat');
        if ($search) {
            $surah->where('nama_latin', 'like', '%' . $search . '%');
        }
        $surah = $surah->paginate($limit);
        foreach ($surah as $surat) {
            $response = Http::get('https://equran.id/api/v2/tafsir/' . $surat->id);
            if ($response->successful()) {
                $tafsir = $response->json();
                $surat->tafsir = $tafsir['data']['tafsir'];
            }
        }
        return ResponseFormated::success($surah, 'data surah berhasil ditambahkan');
    }
}
