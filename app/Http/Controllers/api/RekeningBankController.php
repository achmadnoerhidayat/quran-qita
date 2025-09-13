<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;

use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekeningBankController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $nama = $request->input('nama');
        $limit = $request->input('limit', 20);
        if ($id) {
            $rekening = RekeningBank::where('id', $id)->first();
            if (!$rekening) {
                return ResponseFormated::error(null, 'rekening bank penampung tidak ditemukan', 404);
            }
            return ResponseFormated::success($rekening, 'data rekening bank penampung berhasil ditampilkan');
        }

        $rekening = RekeningBank::select('*');
        if ($nama) {
            $rekening = $rekening->where('nama_bank', 'like', '%' . $nama . '%');
        }

        return ResponseFormated::success($rekening->paginate($limit), 'data rekening bank penampung berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_bank' => ['required', 'string'],
            'nomor_rekening' => ['required', 'numeric'],
            'nama_pemilik' => ['required', 'string'],
        ]);
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data rekening baru."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $rekening = RekeningBank::create($data);
            DB::commit();
            return ResponseFormated::success($rekening, 'data rekening bank penampung berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_bank' => ['nullable', 'string'],
            'nomor_rekening' => ['nullable', 'numeric'],
            'nama_pemilik' => ['nullable', 'string'],
        ]);
        try {
            DB::beginTransaction();
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk mengubah data rekening."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            $rekening = RekeningBank::where('id', $id)->first();
            if (!$rekening) {
                return ResponseFormated::error(null, 'rekening bank penampung tidak ditemukan', 404);
            }
            $rekening->update($data);
            DB::commit();
            return ResponseFormated::success($rekening, 'data rekening bank penampung berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menghapus data rekening."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            $rekening = RekeningBank::where('id', $id)->first();
            if (!$rekening) {
                return ResponseFormated::error(null, 'rekening bank penampung tidak ditemukan', 404);
            }
            $rekening->delete();
            DB::commit();
            return ResponseFormated::success($rekening, 'data rekening bank penampung berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
