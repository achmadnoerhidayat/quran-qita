<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $nama = $request->input('nama');
        $limit = $request->input('limit', 25);
        $user = $request->user();

        if (in_array($user->role, ['admin', 'super-admin'])) {
            if ($id) {
                $donasi = Donation::where('id', $id)->first();
                if (!$donasi) {
                    return ResponseFormated::error(null, 'data donasi tidak ditemukan', 404);
                }
                return ResponseFormated::success($donasi, 'data doasi berhasil ditampilkan');
            }
            $donasi = Donation::with('user', 'rekeningBank', 'detailDonation.admin');
            if ($nama) {
                $donasi = $donasi->where('nama_rekening', 'like', '%' . $nama . '%');
            }
            return ResponseFormated::success($donasi->paginate($limit), 'data donasi berhasil ditampilkan');
        } else {
            if ($id) {
                $donasi = Donation::where('id', $id)->where('user_id', $user->id)->first();
                if (!$donasi) {
                    return ResponseFormated::error(null, 'data donasi tidak ditemukan', 404);
                }
                return ResponseFormated::success($donasi, 'data doasi berhasil ditampilkan');
            }
            $donasi = Donation::with('user', 'rekeningBank', 'detailDonation.admin');
            if ($nama) {
                $donasi = $donasi->where('nama_rekening', 'like', '%' . $nama . '%');
            }
            return ResponseFormated::success($donasi->where('user_id', $user->id)->paginate($limit), 'data donasi berhasil ditampilkan');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rekening_bank_id' => ['required', 'numeric'],
            'jumlah_donasi' => ['required', 'numeric'],
            'metode_pembayaran' => ['required', 'string'],
            'nama_rekening' => ['required', 'string'],
            'nomer_rekening' => ['required', 'numeric'],
            'bukti_transfer' => ['required', 'image', 'mimes:png,jpg,jpeg'],
        ]);

        try {
            DB::beginTransaction();
            $url = null;
            if ($request->hasFile('bukti_transfer')) {
                $photo = $request->file('bukti_transfer');
                $url = $photo->store('asset/donasi', 'public');
            }
            $donasi = Donation::create([
                'user_id' => $request->user()->id,
                'rekening_bank_id' => $data['rekening_bank_id'],
                'jumlah_donasi' => $data['jumlah_donasi'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'nama_rekening' => $data['nama_rekening'],
                'nomer_rekening' => $data['nomer_rekening'],
                'bukti_transfer' => $url,
            ]);
            DB::commit();
            return ResponseFormated::success($donasi, 'data donasi berhasil ditambahkan');
        } catch (\Exception $e) {
            Db::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'rekening_bank_id' => ['required', 'numeric'],
            'jumlah_donasi' => ['required', 'numeric'],
            'metode_pembayaran' => ['required', 'string'],
            'nama_rekening' => ['required', 'string'],
            'nomer_rekening' => ['required', 'numeric'],
            'bukti_transfer' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'status' => ['required', 'string', 'in:Dikonfirmasi,Ditolak'],
            'keterangan_admin' => ['required', 'string'],
        ]);

        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk update donasi."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $donasi = Donation::where('id', $id)->first();
            if (!$donasi) {
                return ResponseFormated::error(null, 'data donasi tidak ditemukan', 404);
            }
            $url = $donasi->bukti_transfer;
            if ($request->hasFile('bukti_transfer')) {
                Storage::disk('public')->delete($url);
                $photo = $request->file('bukti_transfer');
                $url = $photo->store('asset/donasi', 'public');
            }
            $donasi->update([
                'user_id' => $request->user()->id,
                'rekening_bank_id' => $data['rekening_bank_id'],
                'jumlah_donasi' => $data['jumlah_donasi'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'nama_rekening' => $data['nama_rekening'],
                'nomer_rekening' => $data['nomer_rekening'],
                'bukti_transfer' => $url,
                'status' => $data['status'],
                'keterangan_admin' => $data['keterangan_admin'],
            ]);
            $donasi->detailDonation()->create([
                'user_id' => $user->id,
                'aksi' => $data['status'],
                'keterangan' => $data['keterangan_admin'],
            ]);
            DB::commit();
            return ResponseFormated::success($donasi, 'data donasi berhasil ditambahkan');
        } catch (\Exception $e) {
            Db::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = $request->user();
            if (!in_array($user->role, ['admin', 'super-admin'])) {
                return ResponseFormated::error([
                    'errors' => "Peran pengguna $user->role tidak memiliki izin untuk update donasi."
                ], 'Akses ditolak. Hanya administrator yang memiliki izin untuk melakukan aksi ini.', 403);
            }
            DB::beginTransaction();
            $donasi = Donation::where('id', $id)->first();
            if (!$donasi) {
                return ResponseFormated::error(null, 'data donasi tidak ditemukan', 404);
            }
            Storage::disk('public')->delete($donasi->bukti_transfer);
            $donasi->delete();
            $donasi->detailDonation()->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data donasi berhasil dihapus');
        } catch (\Exception $e) {
            Db::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
