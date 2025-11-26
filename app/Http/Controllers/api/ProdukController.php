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
            $trans = TransactionProduct::where('product_id', $produk->id)->first();
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
            $trans = TransactionProduct::where('product_id', $value->id)->first();
            if ($trans) {
                $status_pembelian = true;
            }
            $value['status_pembelian'] = $status_pembelian;
        }
        return ResponseFormated::success($produk, 'data produk berhasil ditampilkan');
    }
}
