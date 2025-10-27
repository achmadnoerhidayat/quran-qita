<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\AsmaulHusna;
use Illuminate\Http\Request;

class AsmaController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $latin = $request->input('latin');
        $limit = $request->input('limit', 25);

        $asma = AsmaulHusna::select('*');
        if ($id) {
            $asma = $asma->where('id', $id)->first();
            if (!$asma) {
                return ResponseFormated::error(null, 'data asmaul husna tidak ditemukan', 404);
            }
            return ResponseFormated::success($asma, 'data asmaul husna berhasil ditampilkan');
        }

        if ($latin) {
            $asma = $asma->where('latin', 'like', '%' . $latin . '%');
        }
        $asma = $asma->paginate($limit);
        return ResponseFormated::success($asma, 'data asmaul husna berhasil ditampilkan');
    }
}
