<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
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
        $data = Gift::orderBy('created_at', 'desc')->paginate($limit);
        return view('gift.index', [
            'data' => $data,
            'title' => 'Dashboard Gift',
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
        $gift = Gift::find($id);
        if (!$gift) {
            return back()->withErrors([
                'error' => 'Gift Tidak Ditemukan',
            ]);
        }

        return view('gift.edit', [
            'data' => $gift,
            'title' => 'Dashboard Gift',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'icon' => ['required', 'image', 'mimes:png,jpg,jpeg,JPG,PNG,JPEG', 'max:51200'],
            'animation_url' => ['required', 'file', 'mimes:gif,webp,mp4,mov,webm', 'max:51200'],
            'coin_cost' => ['required', 'numeric'],
            'deskripsi' => ['required', 'string'],
        ]);

        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }

        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        $url_icon = null;
        $url_animasi = null;
        try {
            DB::beginTransaction();

            if ($request->hasFile('icon')) {
                $photo = $request->file('icon');
                $url_icon = $photo->store('asset/gift', 'public');
                $data['icon'] = $url_icon;
            }

            if ($request->hasFile('animation_url')) {
                $photo_animasi = $request->file('animation_url');
                $url_animasi = $photo_animasi->store('asset/gift', 'public');
                $data['animation_url'] = $url_animasi;
            }

            Gift::create($data);
            DB::commit();
            return redirect()->intended('/gift');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($url_icon) {
                Storage::disk('public')->delete($url_icon);
            }
            if ($url_animasi) {
                Storage::disk('public')->delete($url_animasi);
            }
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,JPG,PNG,JPEG', 'max:51200'],
            'animation_url' => ['nullable', 'file', 'mimes:gif,webp,mp4,mov,webm', 'max:51200'],
            'coin_cost' => ['required', 'numeric', 'min:1'],
            'deskripsi' => ['required', 'string'],
        ]);

        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }

        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        $url_icon = null;
        $url_animasi = null;
        try {
            DB::beginTransaction();
            $gift = Gift::find($id);
            if (!$gift) {
                return back()->withErrors([
                    'error' => 'Gift Tidak Ditemukan',
                ]);
            }

            $url_icon = $gift->icon;
            $url_animasi = $gift->animation_url;
            if ($request->hasFile('icon')) {
                if ($url_icon) {
                    Storage::disk('public')->delete($url_icon);
                }
                $photo = $request->file('icon');
                $url_icon = $photo->store('asset/gift', 'public');
            }
            if ($request->hasFile('animation_url')) {
                if ($url_animasi) {
                    Storage::disk('public')->delete($url_animasi);
                }
                $photo_animasi = $request->file('animation_url');
                $url_animasi = $photo_animasi->store('asset/gift', 'public');
            }

            $gift->update([
                'name' => $data['name'],
                'icon' => $url_icon,
                'animation_url' => $url_animasi,
                'coin_cost' => $data['coin_cost'],
                'deskripsi' => $data['deskripsi'],
            ]);
            DB::commit();
            return redirect()->intended('/gift');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($url_icon) {
                Storage::disk('public')->delete($url_icon);
            }
            if ($url_animasi) {
                Storage::disk('public')->delete($url_animasi);
            }
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }

        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        $url_icon = null;
        $url_animasi = null;
        try {
            DB::beginTransaction();
            $gift = Gift::find($id);
            if (!$gift) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gift Tidak Ditemukan.'
                ]);
            }

            $url_icon = $gift->icon;
            $url_animasi = $gift->animation_url;
            if ($url_icon) {
                Storage::disk('public')->delete($url_icon);
            }
            if ($url_animasi) {
                Storage::disk('public')->delete($url_animasi);
            }

            $gift->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Gift berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            if ($url_icon) {
                Storage::disk('public')->delete($url_icon);
            }
            if ($url_animasi) {
                Storage::disk('public')->delete($url_animasi);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
