<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 20);
        $user = $request->user();
        if ($id) {
            $jurnal = Journal::with('user')->where('id', $id)->where('user_id', $user->id)->first();
            if (!$jurnal) {
                return ResponseFormated::error(null, 'data journal tidak ditemukan', 404);
            }
            return ResponseFormated::success($jurnal, 'data journal berhasil ditampilkan');
        }

        $jurnal = Journal::with('user');
        if ($title) {
            $jurnal = $jurnal->where('title', 'like', '%' . $title . '%');
        }

        $jurnal = $jurnal->where('user_id', $user->id)->paginate($limit);

        return ResponseFormated::success($jurnal, 'data journal berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'activity_type' => ['required', 'in:baca,hafalan,doa,dzikir'],
            'notes' => ['required', 'string'],
            'activity_date' => ['required', 'date']
        ]);
        $user = $request->user();

        try {
            DB::beginTransaction();
            $data['user_id'] = $user->id;
            Journal::create($data);
            DB::commit();
            return ResponseFormated::success(null, 'data journal berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'activity_type' => ['required', 'in:baca,hafalan,doa,dzikir'],
            'notes' => ['required', 'string'],
            'activity_date' => ['required', 'date']
        ]);
        $user = $request->user();

        try {
            DB::beginTransaction();
            $journal = Journal::where('user_id', $user->id)->where('id', $id)->first();
            if (!$journal) {
                return ResponseFormated::error(null, 'data journal tidak ditemukan', 404);
            }
            $data['user_id'] = $user->id;
            $journal->update($data);
            DB::commit();
            return ResponseFormated::success(null, 'data journal berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        try {
            DB::beginTransaction();
            $journal = Journal::where('user_id', $user->id)->where('id', $id)->first();
            if (!$journal) {
                return ResponseFormated::error(null, 'data journal tidak ditemukan', 404);
            }
            $journal->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data journal berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
