<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 25);
        $user = $request->user();
        if ($id) {
            $note = Note::with('user', 'surah', 'ayat')->where('id', $id)->where('user_id', $user->id)->first();
            if (!$note) {
                return ResponseFormated::error(null, 'data note tidak ditemukan', 404);
            }
            return ResponseFormated::success($note, 'data note berhasil ditampilkan');
        }
        $note = Note::with('user', 'surah', 'ayat')->where('user_id', $user->id)->paginate($limit);
        return ResponseFormated::success($note, 'data note berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surah_id' => ['required', 'numeric'],
            'ayat_id' => ['required', 'numeric'],
            'note' => ['required', 'string'],
        ]);
        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            $note = Note::create($data);
            DB::commit();
            return ResponseFormated::success($note, 'data note berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'surah_id' => ['required', 'numeric'],
            'ayat_id' => ['required', 'numeric'],
            'note' => ['required', 'string'],
        ]);
        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            $note = Note::where('id', $id)->first();
            if (!$note) {
                return ResponseFormated::error(null, 'data note tidak ditemukan', 404);
            }
            $note->update($data);
            DB::commit();
            return ResponseFormated::success($note, 'data note berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $note = Note::where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$note) {
                return ResponseFormated::error(null, 'data note tidak ditemukan', 404);
            }
            $note->delete();
            DB::commit();
            return ResponseFormated::success($note, 'data note berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
