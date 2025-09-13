<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DoaController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $group = $request->input('group');
        $tag = $request->input('tag');
        if ($id) {
            $response = Http::get('https://equran.id/api/doa/' . $id);
            if ($response->successful()) {
                $result = $response->json();
                return ResponseFormated::success($result['data'], 'data doa berhasil ditampilkan');
            }
        }
        $response = Http::get('https://equran.id/api/doa', [
            "group" => $group,
            "tag" => $tag,
        ]);
        if ($response->successful()) {
            $result = $response->json();
            return ResponseFormated::success($result['data'], 'data doa berhasil ditampilkan');
        }
    }
}
