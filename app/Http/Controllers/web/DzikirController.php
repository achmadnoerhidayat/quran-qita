<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Dzikir;
use App\Models\TypeDzikir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DzikirController extends Controller
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
        $data = Dzikir::paginate($limit);
        $type = TypeDzikir::all();
        return view('dzikir.index', [
            'data' => $data,
            'type' => $type,
            'title' => 'Dashboard Dzikir',
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
        $data = Dzikir::find($id);
        if (!$data) {
            return back()->withErrors([
                'error' => 'data dzikir tidak ditemukan',
            ]);
        }
        $type = TypeDzikir::all();
        return view('dzikir.edit', [
            'data' => $data,
            'type' => $type,
            'title' => 'Dashboard Dzikir',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required'],
            'arab' => ['required'],
            'indo' => ['required'],
            'ulang' => ['required'],
            'audio' => [
                'required',
                'file',
                'mimes:mp3,mpeg,mpga',
                'max:10240'
            ]
        ]);

        try {
            $url = null;
            DB::beginTransaction();
            if ($request->hasFile('audio')) {
                $photo = $request->file('audio');
                $url = $photo->store('asset/dzikir', 'public');
            }
            $data['url_audio'] = $url;
            Dzikir::create($data);
            DB::commit();
            return redirect()->intended('/dzikir');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'type' => ['required'],
            'arab' => ['required'],
            'indo' => ['required'],
            'ulang' => ['required'],
            'audio' => [
                'nullable',
                'file',
                'mimes:mp3,mpeg,mpga',
                'max:10240'
            ]
        ]);

        try {
            DB::beginTransaction();
            $dzikir = Dzikir::find($id);
            if (!$dzikir) {
                return back()->withErrors([
                    'error' => 'data dzikir tidak ditemukan',
                ]);
            }
            $url = $dzikir->url_audio;
            if ($request->hasFile('audio')) {
                $photo = $request->file('audio');
                $url = $photo->store('asset/dzikir', 'public');
            }
            $data['url_audio'] = $url;
            $dzikir->update($data);
            DB::commit();
            return redirect()->intended('/dzikir');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $dzikir = Dzikir::find($id);
            if (!$dzikir) {
                return response()->json([
                    'success' => false,
                    'message' => 'data dzikir tidak ditemukan.'
                ]);
            }
            if ($dzikir->url_audio) {
                Storage::disk('public')->delete($dzikir->url_audio);
            }
            $dzikir->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data dzikir berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
