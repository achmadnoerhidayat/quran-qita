<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'forum_id' => ['required', 'numeric'],
            'body' => ['required', 'string']
        ]);
        $user = $request->user();
        try {
            DB::beginTransaction();
            $forum = Forum::where('id', $data['forum_id'])->first();
            if (!$forum) {
                return ResponseFormated::error(null, 'data forum tidak ditemukan', 404);
            }
            $data['user_id'] = $user->id;
            $comment = Comment::create($data);
            DB::commit();
            return ResponseFormated::success($comment, 'data comment berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'forum_id' => ['required', 'numeric'],
            'body' => ['required', 'string']
        ]);
        $user = $request->user();
        try {
            DB::beginTransaction();
            $forum = Forum::where('id', $data['forum_id'])->first();
            if (!$forum) {
                return ResponseFormated::error(null, 'data forum tidak ditemukan', 404);
            }
            $data['user_id'] = $user->id;
            $comment = Comment::where('id', $id)->where('user_id', $user->id)->first();
            if (!$comment) {
                return ResponseFormated::error(null, 'data comment tidak ditemukan', 404);
            }
            $comment->update($data);
            DB::commit();
            return ResponseFormated::success($comment, 'data comment berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        try {
            DB::beginTransaction();
            $data['user_id'] = $user->id;
            $comment = Comment::where('id', $id)->where('user_id', $user->id)->first();
            if (!$comment) {
                return ResponseFormated::error(null, 'data comment tidak ditemukan', 404);
            }
            $comment->delete();
            DB::commit();
            return ResponseFormated::success($comment, 'data comment berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function like(Request $request)
    {
        $data = $request->validate([
            'comment_id' => ['required', 'numeric']
        ]);
        $user = $request->user();
        try {
            $comment = Comment::where('id', $data['comment_id'])->first();
            if (!$comment) {
                return ResponseFormated::error(null, 'data forum tidak ditemukan', 404);
            }
            if ($comment->user_id === $user->id) {
                return ResponseFormated::error(null, 'Anda tidak bisa menyukai comment yang Anda buat sendiri.', 403);
            }
            $existingLike = $comment->likes()->where('user_id', $user->id)->first();
            if ($existingLike) {
                // Jika sudah ada like, hapus (unlike)
                $existingLike->delete();
                return ResponseFormated::success(null, 'Unlike berhasil!');
            } else {
                // Jika belum, buat like baru
                $comment->likes()->create(['user_id' => $user->id]);
                return ResponseFormated::success(null, 'Like berhasil!');
            }
        } catch (\Exception $e) {
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
