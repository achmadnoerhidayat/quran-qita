<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\CoinPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoinPackageController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 25);
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = CoinPackage::orderBy('created_at', 'desc')->paginate($limit);
        return view('paket_koin.index', [
            'data' => $data,
            'title' => 'Dashboard Koin',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'coin_amount' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bonus_coin' => ['nullable', 'numeric'],
        ]);

        try {
            DB::beginTransaction();
            if (empty($data['bonus_coin'])) {
                $data['bonus_coin'] = 0;
            }
            CoinPackage::create($data);
            DB::commit();
            return redirect()->intended('/paket');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $paket = CoinPackage::find($id);
        if (!$paket) {
            return back()->withErrors([
                'error' => 'Paket Koin Tidak Ditemukan',
            ]);
        }

        return view('paket_koin.edit', [
            'data' => $paket,
            'title' => 'Dashboard Koin',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'coin_amount' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'bonus_coin' => ['nullable', 'numeric'],
        ]);
        try {
            DB::beginTransaction();
            $paket = CoinPackage::find($id);
            if (!$paket) {
                return back()->withErrors([
                    'error' => 'Paket Koin Tidak Ditemukan',
                ]);
            }
            $paket->update($data);
            DB::commit();
            return redirect()->intended('/paket');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $paket = CoinPackage::find($id);
            if (!$paket) {
                return response()->json([
                    'success' => false,
                    'message' => 'data paket koin tidak ditemukan.'
                ]);
            }
            $paket->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data paket koin berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
