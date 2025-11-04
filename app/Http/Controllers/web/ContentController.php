<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
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
        $data = Content::with('file', 'comments.likes', 'likes')->paginate($limit);
        return view('content.index', [
            'data' => $data,
            'title' => 'Dashboard Konten',
            'class' => 'text-white bg-gray-700'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'content_type' => ['nullable', 'in:vidio,image'],
            'status' => ['nullable', 'in:approved,reject'],
        ]);

        $user = Auth::user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->intended('/logout');
        }

        try {
            DB::beginTransaction();
            $content = Content::find($id);
            if (!$content) {
                return response()->json([
                    'success' => false,
                    'message' => 'data content tidak ditemukan.'
                ]);
            }
            $content->update($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data content berhasil diupdate.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
        try {
            DB::beginTransaction();
            $content = Content::find($id);
            if (!$content) {
                return response()->json([
                    'success' => false,
                    'message' => 'data content tidak ditemukan.'
                ]);
            }
            foreach ($content->file as $uploaded) {
                if ($uploaded->url) {
                    Storage::disk('public')->delete($uploaded->url);
                }
            }
            $content->delete();
            $content->file()->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'data content berhasil dihapus.'
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
