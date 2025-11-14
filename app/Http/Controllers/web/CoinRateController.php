<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\CoinRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoinRateController extends Controller
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
        $data = CoinRate::orderBy('created_at', 'desc')->paginate($limit);
        return view('rate.index', [
            'data' => $data,
            'title' => 'Dashboard Koin',
            'class' => 'text-white bg-gray-700'
        ]);
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

        $data = CoinRate::find($id);

        return view('rate.edit', [
            'data' => $data,
            'title' => 'Dashboard Koin',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:purchase,withdraw'],
            'coin_unit' => ['required', 'numeric'],
            'unit_value' => ['required', 'numeric'],
        ]);

        try {
            DB::beginTransaction();
            CoinRate::where('type', $data['type'])->update([
                'active' => 0
            ]);
            CoinRate::create($data);
            DB::commit();
            return redirect()->intended('/rate');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'type' => ['required', 'in:purchase,withdraw'],
            'coin_unit' => ['required', 'numeric'],
            'unit_value' => ['required', 'numeric'],
            'active' => ['nullable'],
        ]);
        try {
            DB::beginTransaction();
            $rate = CoinRate::find($id);
            if (!$rate) {
                return back()->withErrors([
                    'error' => 'Rate tidak ditemukan',
                ]);
            }
            if (isset($data['active'])) {
                if ($data['active'] == 'on') {
                    CoinRate::where('type', $data['type'])->update([
                        'active' => 0
                    ]);
                    $data['active'] = 1;
                }
            } else {
                $data['active'] = 0;
            }
            $rate->update($data);
            DB::commit();
            return redirect()->intended('/rate');
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
            $rate = CoinRate::find($id);
            if (!$rate) {
                return response()->json([
                    'success' => false,
                    'message' => 'data Rate koin tidak ditemukan.'
                ]);
            }
            $rate->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data Rate koin Berhasil Dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
