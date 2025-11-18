<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\CoinPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoinPackageController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $id = $request->input('id');
        $paket = CoinPackage::select('*');
        if ($id) {
            $paket = $paket->find($id);
            if (!$paket) {
                return ResponseFormated::error(null, 'data paket koin tidak ditemukan', 404);
            }
            return ResponseFormated::success($paket, 'data paket koin berhasil ditampilkan');
        }
        $paket = $paket->orderBy('coin_amount', 'asc')->paginate($limit);
        return ResponseFormated::success($paket, 'data paket koin berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'coin_amount' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bonus_coin' => ['nullable', 'numeric'],
        ]);

        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data paket koin."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }

        try {
            DB::beginTransaction();
            if (empty($data['bonus_coin'])) {
                $data['bonus_coin'] = 0;
            }
            CoinPackage::create($data);
            DB::commit();
            return ResponseFormated::success(null, 'data paket koin berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'coin_amount' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bonus_coin' => ['nullable', 'numeric'],
        ]);

        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data paket koin."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }

        try {
            DB::beginTransaction();
            if (empty($data['bonus_coin'])) {
                $data['bonus_coin'] = 0;
            }
            $paket = CoinPackage::find($id);
            if (!$paket) {
                return ResponseFormated::error(null, 'data paket koin tidak ditemukan', 404);
            }
            $paket->update($data);
            DB::commit();
            return ResponseFormated::success(null, 'data paket koin berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data paket koin."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }

        try {
            DB::beginTransaction();
            $paket = CoinPackage::find($id);
            if (!$paket) {
                return ResponseFormated::error(null, 'data paket koin tidak ditemukan', 404);
            }
            $paket->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data paket koin berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
