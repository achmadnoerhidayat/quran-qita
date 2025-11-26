<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $order = $request->input('order_by', 'desc');
        $limit = $request->input('limit', 20);
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = Product::with('category')->orderBy('created_at', $order)->paginate($limit);
        $kategori = Category::all();
        return view('produk.index', [
            'data' => $data,
            'kategori' => $kategori,
            'title' => 'Dashboard Produk',
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
        $data = Product::find($id);
        $kategori = Category::all();
        return view('produk.edit', [
            'data' => $data,
            'kategori' => $kategori,
            'title' => 'Dashboard Produk',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'numeric'],
            'title' => ['required', 'min:5', 'max:25'],
            'price' => ['required', 'numeric'],
            'duration' => ['nullable', 'numeric'],
            'icon' => ['required', 'image', 'mimes:png,jpg,jpeg,JPG,PNG,JPEG'],
            'deskripsi' => ['required']
        ]);

        $url = null;
        try {
            DB::beginTransaction();
            if ($request->hasFile('icon')) {
                $photo = $request->file('icon');
                $url = $photo->store('asset/produk', 'public');
                $data['icon'] = $url;
            }
            if (empty($data['duration'])) {
                $data['duration'] = 0;
            }
            Product::create($data);
            DB::commit();
            return redirect()->intended('/produk');
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($url)) {
                Storage::disk('public')->delete($url);
            }
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_id' => ['required', 'numeric'],
            'title' => ['required', 'min:5', 'max:25'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,JPG,PNG,JPEG'],
            'deskripsi' => ['required', 'min:5']
        ]);

        $url = null;

        try {
            DB::beginTransaction();
            $produk = Product::find($id);
            if (!$produk) {
                return back()->withErrors([
                    'error' => 'Data Produk Tidak Ditemukan',
                ]);
            }
            if ($request->hasFile('icon')) {
                $url = $produk->icon;
                if (!empty($url)) {
                    Storage::disk('public')->delete($url);
                }
                $photo = $request->file('icon');
                $url = $photo->store('asset/produk', 'public');
                $data['icon'] = $url;
            }
            $produk->update($data);
            DB::commit();
            return redirect()->intended('/produk');
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($url)) {
                Storage::disk('public')->delete($url);
            }
            dd($e->getMessage());
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        $url = null;
        try {
            DB::beginTransaction();
            $produk = Product::find($id);
            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Produk Tidak Ditemukan'
                ]);
            }
            $url = $produk->icon;
            if (!empty($url)) {
                Storage::disk('public')->delete($url);
            }
            $produk->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data produk berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($url)) {
                Storage::disk('public')->delete($url);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
