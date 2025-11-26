<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\CoinTransaction;
use App\Models\Product;
use App\Models\TransactionProduct;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiProdukController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 25);
        $user = $request->user();
        $trans = TransactionProduct::with('detail', 'user.wallet', 'produk.category');
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            if ($id) {
                $trans = $trans->where('id', $id)->where('user_id', $user->id)->first();
                return ResponseFormated::success($trans, 'data transaksi produk berhasil ditampilkan');
            }
            $trans = $trans->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate($limit);
            return ResponseFormated::success($trans, 'data transaksi produk berhasil ditampilkan');
        }
        if ($id) {
            $trans = $trans->where('id', $id)->first();
            return ResponseFormated::success($trans, 'data transaksi produk berhasil ditampilkan');
        }
        $trans = $trans->orderBy('created_at', 'desc')->paginate($limit);
        foreach ($trans as $key => $value) {
            $history = CoinTransaction::where('user_id', $value->user_id)->orderBy('created_at', 'desc')->get();
            $value['user']['wallet']['history'] = $history;
        }
        return ResponseFormated::success($trans, 'data transaksi produk berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'numeric']
        ]);
        try {
            DB::beginTransaction();
            $wallet = UserWallet::where('user_id', $request->user()->id)->first();
            if (!$wallet) {
                return ResponseFormated::error(null, 'data user wallet tidak ditemukan', 404);
            }
            $produk = Product::find($data['product_id']);
            if (!$produk) {
                return ResponseFormated::error(null, 'data produk tidak ditemukan', 404);
            }
            $startBalance = $wallet->coins;
            $endBalance = $startBalance - $produk->price;
            if ($endBalance  < 0) {
                return ResponseFormated::error(null, 'saldo anda tidak mencukupi segera isi ulang koin anda', 400);
            }
            $existTrans = TransactionProduct::where('product_id', $data['product_id'])->first();

            if ($existTrans) {
                return ResponseFormated::error(null, 'anda sdh membeli produk ini harap pilih produk yang lain', 400);
            }

            $trans = TransactionProduct::create([
                'user_id' => $wallet->user_id,
                'amount_coin' => $produk->price,
                'starts_at' => Carbon::now(),
                'end_at' => ($produk->duration > 0) ? Carbon::now()->addDays($produk->duration) : null,
                'exp_refund' => Carbon::now()->addMinutes(10),
                'product_id' => $data['product_id'],
                'status' => 'success'
            ]);

            $trans->detail()->create([
                'user_id' => $wallet->user_id,
                'aksi' => 'Dikonfirmasi',
                'keterangan' => 'Pembelian ' . $produk->title
            ]);

            $wallet->update(['coins' => $endBalance]);
            CoinTransaction::create([
                'user_id' => $wallet->user_id,
                'type' => 'pembelian',
                'start_balance' => $startBalance,
                'end_balance' => $endBalance,
                'amount_coin' => $produk->price,
            ]);
            DB::commit();
            return ResponseFormated::success(null, 'pembelian produk berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 400);
        }
    }

    public function refund(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => ['required', 'numeric'],
        ]);
        try {
            DB::beginTransaction();
            $wallet = UserWallet::where('user_id', $request->user()->id)->first();
            if (!$wallet) {
                return ResponseFormated::error(null, 'data user wallet tidak ditemukan', 404);
            }

            $trans = TransactionProduct::where('id', $data['transaction_id'])->where('exp_refund', '>', Carbon::now())->first();

            if (!$trans) {
                return ResponseFormated::error(null, 'Transaksi tidak tersedia atau waktu pengajuan refund sudah habis.', 404);
            }

            $produk = Product::find($trans->product_id);
            if (!$produk) {
                return ResponseFormated::error(null, 'data produk tidak ditemukan', 404);
            }

            $startBalance = $wallet->coins;
            $endBalance = $startBalance + $produk->price;

            $trans->update([
                'user_id' => $wallet->user_id,
                'amount_coin' => $produk->price,
                'status' => 'refund'
            ]);

            $trans->detail()->create([
                'user_id' => $wallet->user_id,
                'aksi' => 'Dikonfirmasi',
                'keterangan' => 'Pengembalian Dana Koin ' . $produk->price
            ]);

            $wallet->update(['coins' => $endBalance]);
            CoinTransaction::create([
                'user_id' => $wallet->user_id,
                'type' => 'refund',
                'start_balance' => $startBalance,
                'end_balance' => $endBalance,
                'amount_coin' => $produk->price,
            ]);
            DB::commit();
            return ResponseFormated::success(null, 'refund pembelian produk berhasil ditambahkan ke saldo pengguna');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 400);
        }
    }
}
