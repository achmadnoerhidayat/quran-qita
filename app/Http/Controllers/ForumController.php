<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $limit = $request->input('limit', 25);
        if ($id) {
            $forum = Forum::with('user')->where('id', $id)->where('user_id', $request->user()->id)->first();
            if (!$forum) {
                return ResponseFormated::error(null, 'data forum post tidak ditemukan', 404);
            }
            return ResponseFormated::success($forum, 'data forum post berhasil ditambahkan');
        }
        $forum = Forum::with('user');
        if ($title) {
            $forum->where('title', 'like', '%' . $title . '%');
        }
        $forum = $forum->where('user_id', $request->user()->id)->paginate($limit);
        return ResponseFormated::success($forum, 'data forum post berhasil ditambahkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        try {
            DB::beginTransaction();
            $forum = Forum::create([
                'user_id' => $request->user()->id,
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
            $resp = Forum::with('user')->where('id', $forum->id)->first();
            DB::commit();
            return ResponseFormated::success($resp, 'data forum post berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        try {
            DB::beginTransaction();

            $forum = Forum::where('user_id', $request->user()->id)->where('id', $id)->first();
            if (!$forum) {
                return ResponseFormated::error(null, 'data forum post tidak ditemukan', 404);
            }
            $forum->update([
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
            $resp = Forum::with('user')->where('id', $forum->id)->first();
            DB::commit();
            return ResponseFormated::success($resp, 'data forum post berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $forum = Forum::where('user_id', $request->user()->id)->where('id', $id)->first();
            if (!$forum) {
                return ResponseFormated::error(null, 'data forum post tidak ditemukan', 404);
            }
            $forum->delete();
            DB::commit();
            return ResponseFormated::success(null, 'data forum post berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }
}
