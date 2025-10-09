<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Ayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AyatController extends Controller
{
    public function edit($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }
        $data = Ayat::find($id);
        if (!$data) {
            return back()->withErrors([
                'error' => 'data surah tidak ditemukan',
            ]);
        }
        return view('ayat.edit', [
            'data' => $data,
            'title' => 'Dashboard quran',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nomor_ayat' => ['required', 'numeric'],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['required', 'string'],
            'teks_indo' => ['required', 'string'],
            'teks_english' => ['required', 'string'],
            'audio' => ['required', 'array'],
            'audio.*' => ['required', 'url'],
        ]);
        $data['audio'] = collect($data['audio'])->mapWithKeys(function ($value, $index) {
            // ubah angka jadi string dua digit (leading zero)
            $key = str_pad($index + 1, 2, '0', STR_PAD_LEFT); // jadi '01', '02', dst
            return [$key => $value];
        })->toArray();
        try {
            DB::beginTransaction();
            $surah = Ayat::find($id);
            if (!$surah) {
                return back()->withErrors([
                    'error' => 'data ayat tidak ditemukan',
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
        $surah = Ayat::find($id);
        if (!$surah) {
            return back()->withErrors([
                'error' => 'data ayat tidak ditemukan',
            ]);
        }
        $audioToRemove = $data['audio'];
        if (Str::startsWith($audioToRemove, asset('storage'))) {
            $relativePath = str_replace(asset('storage') . '/', '', $audioToRemove);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
        $audios = array_filter($surah->audio ?? [], function ($audio) use ($audioToRemove) {
            return $audio !== $audioToRemove;
        });
        $data = collect($audios)->mapWithKeys(function ($value, $index) {
            // ubah angka jadi string dua digit (leading zero)
            $key = str_pad($index + 1, 2, '0', STR_PAD_LEFT); // jadi '01', '02', dst
            return [$key => $value];
        })->toArray();
        $surah->audio = $data;
        $surah->save();
        return response()->json([
            'success' => true,
            'message' => 'Audio berhasil dihapus.'
        ]);
    }

    public function uploadAudio(Request $request)
    {
        $request->validate([
            'audio' => ['required', 'file', 'mimes:mp3']
        ]);

        if ($request->hasFile('audio')) {
            $photo = $request->file('audio');
            $url = $photo->store('asset/ayat', 'public');
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
