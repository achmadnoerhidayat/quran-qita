<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiProdukController extends Controller
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

        $data = TransactionProduct::with('user', 'produk')->orderBy('created_at', 'desc')->paginate($limit);
        return view('transaksi_produk.index', [
            'data' => $data,
            'title' => 'Dashboard Produk',
            'class' => 'text-white bg-gray-700'
        ]);
    }
}
