<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $slug = $request->input('slug');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);
        if ($id) {
            $plan = Plan::where('id', $id)->first();
            if (!$plan) {
                return ResponseFormated::error(null, 'data plan tidak ditemukan', 404);
            }
            return ResponseFormated::success($plan, 'data plan berhasil ditampilkan');
        }

        $plan = Plan::select('*');
        if ($slug) {
            $plan->where('slug', $slug);
        }

        if ($name) {
            $plan->where('slug', 'like', '%' . $slug . '%');
        }

        $plan = $plan->paginate($limit);
        return ResponseFormated::success($plan, 'data plan berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
            'description' => ['required', 'string'],
        ]);
        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menambahkan data plan / paket berlangganan."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }
        try {
            DB::beginTransaction();
            $data['slug'] = Str::slug($data['name']);
            $plan = Plan::create($data);
            DB::commit();
            return ResponseFormated::success($plan, 'data plan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
            'description' => ['required', 'string'],
        ]);
        $user = $request->user();
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return ResponseFormated::error([
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk mengubah data plan / paket berlangganan."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }
        try {
            DB::beginTransaction();
            $plan = Plan::where('id', $id)->first();
            if (!$plan) {
                return ResponseFormated::error(null, 'data plan tidak ditemukan', 404);
            }
            $data['slug'] = Str::slug($data['name']);
            $plan->update($data);
            DB::commit();
            return ResponseFormated::success($plan, 'data plan berhasil diupdate');
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
                'errors' => "Peran pengguna $user->role tidak memiliki izin untuk menghapus data plan / paket berlangganan."
            ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
        }
        try {
            DB::beginTransaction();
            $plan = Plan::where('id', $id)->first();
            if (!$plan) {
                return ResponseFormated::error(null, 'data plan tidak ditemukan', 404);
            }
            $plan->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data plan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
