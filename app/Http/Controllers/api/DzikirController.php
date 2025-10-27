<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Dzikir;
use Illuminate\Http\Request;

class DzikirController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $limit = $request->input('limit', 25);

        $dzikir = Dzikir::select('*');

        if ($id) {
            $dzikir = $dzikir->where('id', $id)->first();
            if (!$dzikir) {
                return ResponseFormated::error(null, 'data dzikir tidak ditemukan', 404);
            }
            return ResponseFormated::success($dzikir, 'data dzikir berhasil ditampilkan');
        }

        if ($type) {
            $dzikir = $dzikir->where('type', $type);
        }

        $dzikir = $dzikir->paginate($limit);

        return ResponseFormated::success($dzikir, 'data dzikir berhasil ditampilkan');
    }
}
