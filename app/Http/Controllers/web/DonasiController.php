<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = Donation::with('user', 'rekeningBank')->orderBy('created_at', 'desc')->paginate(25);
        return view('donasi.index', [
            'data' => $data,
            'title' => 'Dashboard Donasi',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = Donation::with('user', 'rekeningBank')->find($id);
        return view('donasi.show', [
            'data' => $data,
            'title' => 'Dashboard Donasi',
            'class' => 'text-white bg-gray-700'
        ]);
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'status' => ['required', 'in:Ditolak,Dikonfirmasi,Menunggu Konfirmasi']
        ]);
        $donasi = Donation::find($id);
        if (!$donasi) {
            return response()->json([
                'success' => false,
                'message' => 'data donasi tidak ditemukan.'
            ]);
        }
        $donasi->update($data);
        return response()->json([
            'success' => true,
            'message' => 'data donasi berhasil diupdate.'
        ]);
    }
}
