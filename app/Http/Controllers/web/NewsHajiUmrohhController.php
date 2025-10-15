<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\HajiNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsHajiUmrohhController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = HajiNews::with('user')->orderBy('created_at', 'desc')->paginate(5);
        return view('berita.newshaji', [
            'data' => $data,
            'title' => 'Dashboard Haji Umroh',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg']
        ]);
        $url = null;
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $photo = $request->file('image');
                $url = $photo->store('asset/berita-haji', 'public');
            }
            $data['user_id'] = Auth::user()->id;
            $data['image'] = $url;
            HajiNews::create($data);
            DB::commit();
            return redirect()->intended('/haji-umroh');
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($url);
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        $data = HajiNews::with('user')->where('id', $id)->first();
        return view('berita.edit', [
            'data' => $data,
            'title' => 'Dashboard Haji Umroh',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ]);

        $url = null;
        try {
            DB::beginTransaction();
            $news = HajiNews::with('user')->where('id', $id)->first();
            if (!$news) {
                return back()->withErrors([
                    'error' => 'Data Berita Haji Tidak Ditemukan',
                ]);
            }
            $url = $news->image;
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($url);
                $photo = $request->file('image');
                $url = $photo->store('asset/berita-haji', 'public');
            }
            $data['user_id'] = Auth::user()->id;
            $data['image'] = $url;
            $news->update($data);
            DB::commit();
            return redirect()->intended('/haji-umroh');
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($url);
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
            $news = HajiNews::with('user')->where('id', $id)->first();
            if (!$news) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Berita Haji Tidak Ditemukan.'
                ]);
            }
            $url = $news->image;
            if ($url) {
                Storage::disk('public')->delete($url);
            }
            $news->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data Berita Haji berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($url);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
