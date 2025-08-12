<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $search = $request->input('search');
        $limit = $request->input('limit', 25);
        $user = $request->user();
        if ($id) {
            $bookmark = Bookmark::with('user', 'surah', 'ayat')->where('user_id', $user->id)->where('id', $id)->first();
            if (!$bookmark) {
                return ResponseFormated::error(null, 'data bookmark tidak ditemukan', 404);
            }
            return ResponseFormated::success($bookmark, 'data bookmark berhasil ditambahkan');
        }

        $bookmark = Bookmark::with('user', 'surah', 'ayat');
        if ($search) {
            $bookmark->whereHas('surah', function ($s) use ($search) {
                $s->where('nama_latin', 'like', '%' . $search . '%');
            })->orWhereHas('ayat', function ($a) use ($search) {
                $a->where('nomor_ayat', 'like', '%' . $search . '%');
            });
        }

        $bookmark = $bookmark->where('user_id', $user->id)->paginate($limit);
        return ResponseFormated::success($bookmark, 'data bookmark berhasil ditambahkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surah_id' => ['nullable', 'numeric'],
            'ayat_id' => ['nullable', 'numeric'],
        ]);
        try {
            DB::beginTransaction();
            $bookmark = Bookmark::create([
                'user_id' => $request->user()->id,
                'surah_id' => $data['surah_id'],
                'ayat_id' => $data['ayat_id'],
            ]);
            $response = Bookmark::with('user', 'surah', 'ayat')->where('id', $bookmark->id)->first();
            DB::commit();
            return ResponseFormated::success($response, 'data bookmark berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'surah_id' => ['nullable', 'numeric'],
            'ayat_id' => ['nullable', 'numeric'],
        ]);
        try {
            DB::beginTransaction();
            $book = Bookmark::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$book) {
                return ResponseFormated::error(null, 'data bookmark tidak ditemukan', 404);
            }
            $book->update([
                'surah_id' => $data['surah_id'],
                'ayat_id' => $data['ayat_id'],
            ]);
            DB::commit();
            return ResponseFormated::success($book, 'data bookmark berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $book = Bookmark::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$book) {
                return ResponseFormated::error(null, 'data bookmark tidak ditemukan', 404);
            }
            $book->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data bookmark berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
