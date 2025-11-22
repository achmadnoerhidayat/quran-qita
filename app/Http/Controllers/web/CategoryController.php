<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
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
        $data = Category::orderBy('created_at', $order)->paginate($limit);
        return view('kategori.index', [
            'data' => $data,
            'title' => 'Dashboard Kategori',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'min:5', 'max:20'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,JPG,PNG,JPEG']
        ]);
        $url = null;
        try {
            DB::beginTransaction();
            if ($request->hasFile('icon')) {
                $photo = $request->file('icon');
                $url = $photo->store('asset/kategori', 'public');
                $data['icon'] = $url;
            }
            Category::create($data);
            DB::commit();
            return redirect()->intended('/kategori');
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

    public function edit($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $kategori = Category::find($id);
        if (!$kategori) {
            return back()->withErrors([
                'error' => 'Kategori Tidak Ditemukan',
            ]);
        }
        return view('kategori.edit', [
            'data' => $kategori,
            'title' => 'Dashboard Kategori',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['required', 'min:5', 'max:25'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,JPG,PNG,JPEG']
        ]);
        $url = null;
        try {
            DB::beginTransaction();
            $kategori = Category::find($id);
            if (!$kategori) {
                return back()->withErrors([
                    'error' => 'Kategori Tidak Ditemukan',
                ]);
            }
            if ($request->hasFile('icon')) {
                $url = $kategori->icon;
                if (!empty($url)) {
                    Storage::disk('public')->delete($url);
                }
                $photo = $request->file('icon');
                $url = $photo->store('asset/kategori', 'public');
                $data['icon'] = $url;
            }
            $kategori->update($data);
            DB::commit();
            return redirect()->intended('/kategori');
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
}
