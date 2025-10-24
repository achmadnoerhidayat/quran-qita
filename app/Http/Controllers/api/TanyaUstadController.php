<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\AskUstadz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanyaUstadController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 25);
        $ustdad = AskUstadz::with('user');
        if ($id) {
            $ustdad = $ustdad->where('id', $id)->first();
            if (!$ustdad) {
                return ResponseFormated::error(null, 'data tanya ustad tidak ditemukan', 404);
            }
            return ResponseFormated::success($ustdad, 'data tanya ustad berhadsil ditampilkan');
        }

        $ustdad = $ustdad->paginate($limit);
        return ResponseFormated::success($ustdad, 'data ustad berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $data['user_id'] = $request->user()->id;
            AskUstadz::create($data);
            DB::commit();
            return ResponseFormated::success(null, 'data tanya ustad berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'pertanyaan' => ['required', 'min:5'],
            'jawaban' => ['nullable', 'min:5', 'max:255']
        ]);
        try {
            DB::beginTransaction();
            $ustad = AskUstadz::find($id);
            if (!$ustad) {
                return ResponseFormated::error(null, 'data tanya ustad tidak ditemukan', 404);
            }
            if (isset($data['jawaban'])) {
                $data['status'] = 'dijawab';
            }
            $ustad->update($data);
            DB::commit();
            return ResponseFormated::success(null, 'data tanya ustad berhasil di update');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete($id)
    {
        $ustad = AskUstadz::find($id);
        if (!$ustad) {
            return ResponseFormated::error(null, 'data tanya ustad tidak ditemukan', 404);
        }
        $ustad->delete();
        return ResponseFormated::success(null, 'data tanya ustad berhasil dihapus');
    }
}
