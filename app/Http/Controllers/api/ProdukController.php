<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Product;
use App\Models\TransactionProduct;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $limit = $request->input('limit', 20);

        $produk = Product::with('category');
        if ($id) {
            $produk = $produk->find($id);
            if (!$produk) {
                return ResponseFormated::error(null, 'data produk tidak ditemukan', 404);
            }
            $status_pembelian = false;
            $trans = TransactionProduct::where('product_id', $produk->id)->where('user_id', $request->user()->id)->where('status', 'success')->first();
            if ($trans) {
                $status_pembelian = true;
            }
            $produk['status_pembelian'] = $status_pembelian;
            return ResponseFormated::success($produk, 'data produk berhasil ditampilkan');
        }

        if ($category_id) {
            $produk = $produk->where('category_id', $category_id);
        }

        if ($title) {
            $produk = $produk->where('title', 'like', '%' . $title . '%');
        }
        $produk = $produk->orderBy('title', 'asc')->paginate($limit);
        foreach ($produk as $key => $value) {
            $status_pembelian = false;
            $is_active = false;
            $trans = TransactionProduct::where('product_id', $value->id)->where('user_id', $request->user()->id)->where('status', 'success')->first();
            if ($trans) {
                $is_active = $trans->is_active;
                $status_pembelian = true;
            }
            $value['is_active'] = $is_active;
            $value['status_pembelian'] = $status_pembelian;
        }
        return ResponseFormated::success($produk, 'data produk berhasil ditampilkan');
    }

    public function useProduk(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'numeric']
        ]);

        $user = $request->user();

        $trans = TransactionProduct::where('product_id', $data['product_id'])->where('user_id', $user->id)->where('status', 'success')->first();

        if (!$trans) {
            return ResponseFormated::error(null, 'produk tidak ditemukan atau produk yang di beli belum selesai', 404);
        }

        $category = $trans->produk->category_id;
        TransactionProduct::where('user_id', $user->id)
            ->whereHas('produk', function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->update(['is_active' => false]);

        $trans->update(['is_active' => true]);

        return ResponseFormated::success(null, 'produk berhasil diaktifkan');
    }
}
