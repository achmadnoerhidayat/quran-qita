<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 25);
        $status = $request->input('status', 'approved');
        $content = Content::with('file', 'user', 'comments.likes.user', 'likes.user')->where('status', $status);

        if ($id) {
            $content = $content->where('id', $id)->first();
            if (!$content) {
                return ResponseFormated::error(null, 'data content tidak ditemukan', 404);
            }
            return ResponseFormated::success($content, 'data content berhasil ditampilkan');
        }

        $content = $content->paginate($limit);

        return ResponseFormated::success($content, 'data content berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $rules = [
            'content_type' => ['required', 'in:vidio,image'],
            'deskripsi'    => ['required', 'min:10', 'string', 'max:500'],
            'file'    => ['required', 'array', 'min:1'],
            'file.*'    => ['file'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->sometimes('file.*', [
            'required',
            'mimes:mp4,mov,ogg,webm',
            'max:50000'
        ], function ($input) {
            return $input->content_type === 'vidio';
        });

        $validator->sometimes('file.*', [
            'required',
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:10000'
        ], function ($input) {
            return $input->content_type === 'image';
        });

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $data = $validator->validated();
            $kontent = Content::create([
                'user_id' => $request->user()->id,
                'content_type' => $data['content_type'],
                'deskripsi' => $data['deskripsi'],
            ]);
            $uploaded_urls = [];
            foreach ($request->file('file') as $uploaded) {
                $name = $uploaded->getClientOriginalName();
                $url = $uploaded->store('asset/content', 'public');
                $uploaded_urls[] = $url;
                $kontent->file()->create([
                    'url' => $url,
                    'filename' => $name
                ]);
            }
            DB::commit();
            return ResponseFormated::success($kontent, 'data content berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            foreach ($uploaded_urls as $link) {
                if ($link) {
                    Storage::disk('public')->delete($link);
                }
            }
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function like(Request $request)
    {
        $data = $request->validate([
            'content_id' => ['required', 'numeric']
        ]);
        $user = $request->user();
        try {
            $forum = Content::where('id', $data['content_id'])->first();
            if (!$forum) {
                return ResponseFormated::error(null, 'data konten tidak ditemukan', 404);
            }
            if ($forum->user_id === $user->id) {
                return ResponseFormated::error(null, 'Anda tidak bisa menyukai konten yang Anda buat sendiri.', 403);
            }
            $existingLike = $forum->likes()->where('user_id', $user->id)->first();
            if ($existingLike) {
                // Jika sudah ada like, hapus (unlike)
                $existingLike->delete();
                return ResponseFormated::success(null, 'Unlike berhasil!');
            } else {
                // Jika belum, buat like baru
                $forum->likes()->create(['user_id' => $user->id]);
                return ResponseFormated::success(null, 'Like berhasil!');
            }
        } catch (\Exception $e) {
            //throw $th;
        }
    }
}
