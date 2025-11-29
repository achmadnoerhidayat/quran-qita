<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\CoinPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiCoinController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 20);
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        $data = CoinPurchase::with('user', 'package')->orderBy('created_at', 'desc')->paginate($limit);
        return view('transaksi_koin.index', [
            'data' => $data,
            'title' => 'Dashboard Koin',
            'class' => 'text-white bg-gray-700'
        ]);
    }
}
