<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\TypeDzikir;
use Illuminate\Http\Request;

class TypeDzikirController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 25);

        $type = TypeDzikir::select('*');
        if ($id) {
            $type = $type->where('id', $id)->first();
            if (!$type) {
                return ResponseFormated::error(null, 'data type dzikir tidak ditemukan', 404);
            }
            return ResponseFormated::success($type, 'data type dzikir berhasil ditampilkan');
        }

        if ($name) {
            $type = $type->where('name', 'like', '%' . $name . '%');
        }

        $type = $type->paginate($limit);
        return ResponseFormated::success($type, 'data type dzikir berhasil ditampilkan');
    }
}
