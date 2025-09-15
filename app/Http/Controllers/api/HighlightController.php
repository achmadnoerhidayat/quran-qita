<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HighlightController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 25);
        $user = $request->user();
        if ($id) {
            $hight = Highlight::with('user', 'surah', 'ayat')->where('id', $id)->where('user_id', $user->id)->first();
            if (!$hight) {
                return ResponseFormated::error(null, 'data highlight tidak ditemukan', 404);
            }
            return ResponseFormated::success($hight, 'data highlight berhasil ditampilkan');
        }
        $hight = Highlight::with('user', 'surah', 'ayat')->where('user_id', $user->id)->paginate($limit);
        return ResponseFormated::success($hight, 'data highlight berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surah_id' => ['required', 'numeric'],
            'ayat_id' => ['nullable', 'numeric']
        ]);
        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            $highlight = Highlight::create($data);
            DB::commit();
            return ResponseFormated::success($highlight, 'data highlight berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'surah_id' => ['required', 'numeric'],
            'ayat_id' => ['nullable', 'numeric']
        ]);
        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            $highlight = Highlight::where('id', $id)->first();
            if (!$highlight) {
                return ResponseFormated::error(null, 'data highlight tidak ditemukan', 404);
            }
            $highlight->update($data);
            DB::commit();
            return ResponseFormated::success($highlight, 'data note berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $highlight = Highlight::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$highlight) {
                return ResponseFormated::error(null, 'data highlight tidak ditemukan', 404);
            }
            $highlight->delete();
            DB::commit();
            return ResponseFormated::success($highlight, 'data highlight berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function deleteAll(Request $request)
    {
        try {
            DB::beginTransaction();
            $highlight = Highlight::where('user_id', $request->user()->id)->delete();
            DB::commit();
            return ResponseFormated::success($highlight, 'data highlight berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
