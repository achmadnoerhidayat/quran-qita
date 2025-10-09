<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuranController extends Controller
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
        $data = Surah::with('ayat')->paginate($limit);
        return view('quran.index', [
            'data' => $data,
            'title' => 'Dashboard quran',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = Surah::with('ayat')->where('id', $id)->first();
        if (!$data) {
            return back()->withErrors([
                'error' => 'data surah tidak ditemukan',
            ]);
        }
        return view('quran.show', [
            'data' => $data,
            'title' => 'Dashboard quran',
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
        $data = Surah::with('ayat')->where('id', $id)->first();
        if (!$data) {
            return back()->withErrors([
                'error' => 'data surah tidak ditemukan',
            ]);
        }
        return view('quran.edit', [
            'data' => $data,
            'title' => 'Dashboard quran',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nomor' => ['required', 'numeric'],
            'nama' => ['required', 'string'],
            'nama_latin' => ['required', 'string'],
            'jumlah_ayat' => ['required', 'numeric'],
            'tempat_turun' => ['required', 'string'],
            'arti' => ['required', 'string'],
            'arti_english' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'audio_full' => ['required', 'array'],
        ]);
        $data['audio_full'] = collect($data['audio_full'])->mapWithKeys(function ($value, $index) {
            // ubah angka jadi string dua digit (leading zero)
            $key = str_pad($index + 1, 2, '0', STR_PAD_LEFT); // jadi '01', '02', dst
            return [$key => $value];
        })->toArray();
        try {
            DB::beginTransaction();
            $surah = Surah::find($id);
            if (!$surah) {
                return back()->withErrors([
                    'error' => 'data surah tidak ditemukan',
                ]);
            }
            $surah->update($data);
            DB::commit();
            return redirect()->intended('/quran');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function deleteAudio(Request $request, $id)
    {
        $data = $request->validate(['audio' => ['required']]);
        $surah = Surah::find($id);
        if (!$surah) {
            return back()->withErrors([
                'error' => 'data surah tidak ditemukan',
            ]);
        }
        $audioToRemove = $data['audio'];
        if (Str::startsWith($audioToRemove, asset('storage'))) {
            $relativePath = str_replace(asset('storage') . '/', '', $audioToRemove);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
        $audios = array_filter($surah->audio_full ?? [], function ($audio) use ($audioToRemove) {
            return $audio !== $audioToRemove;
        });
        $data = collect($audios)->mapWithKeys(function ($value, $index) {
            // ubah angka jadi string dua digit (leading zero)
            $key = str_pad($index + 1, 2, '0', STR_PAD_LEFT); // jadi '01', '02', dst
            return [$key => $value];
        })->toArray();
        $surah->audio_full = $data;
        $surah->save();
        return response()->json([
            'success' => true,
            'message' => 'Audio berhasil dihapus.'
        ]);
    }

    public function uploadAudio(Request $request)
    {
        $request->validate([
            'audio' => [
                'required',
                'file',
                'mimetypes:audio/mpeg,audio/mpga,audio/mp3',
                'max:10240'
            ]
        ]);

        if ($request->hasFile('audio')) {
            $photo = $request->file('audio');
            $url = $photo->store('asset/surah', 'public');
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $url)
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'File audio tidak ditemukan'
        ], 400);
    }
}
