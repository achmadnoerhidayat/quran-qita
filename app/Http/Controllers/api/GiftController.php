<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 20);

        $gift = Gift::select('*');
        if ($id) {
            $gift = $gift->where('id', $id)->first();
            if (!$gift) {
                return ResponseFormated::error(null, 'data gift tidak ditemukan', 404);
            }
            return ResponseFormated::success($gift, 'data gift berhasil ditampilkan');
        }
        if ($name) {
            $gift = $gift->where('name', 'like', '%' . $name . '%');
        }
        $gift = $gift->paginate($limit);
        return ResponseFormated::success($gift, 'data gift berhasil ditampilkan');
    }
}
