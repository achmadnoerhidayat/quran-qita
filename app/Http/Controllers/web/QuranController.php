<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $data = $request->validate(['audio' => ['required', 'url']]);
        $surah = Surah::find($id);
        if (!$surah) {
            return back()->withErrors([
                'error' => 'data surah tidak ditemukan',
            ]);
        }
        $audioToRemove = $data['audio'];
        $audios = array_filter($surah->audio_full ?? [], function ($audio) use ($audioToRemove) {
            return $audio !== $audioToRemove;
        });
        $surah->audio_full = array_values($audios);
        $surah->save();
        return back()->with('success', 'Audio berhasil dihapus');
    }
}
