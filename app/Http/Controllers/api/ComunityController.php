<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Comunity;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComunityController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 20);

        $comunity = Comunity::with(['post' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }, 'post.user', 'post.likes.user', 'post.comments.user', 'post.comments.likes.user', 'member.user']);
        if ($id) {
            $comunity = $comunity->where('id', $id)->first();
            if (!$comunity) {
                return ResponseFormated::error(null, 'data komunitas tidak ditemukan', 404);
            }
            return ResponseFormated::success($comunity, 'data komunitas berhasil ditampilkan');
        }

        if ($name) {
            $comunity = $comunity->where('name', 'like', '%' . $name . '%');
        }

        $comunity = $comunity->paginate($limit);
        return ResponseFormated::success($comunity, 'data komunitas berhasil ditampilkan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ]);
        $url = null;
        try {
            DB::beginTransaction();
            if ($request->hasFile('logo')) {
                $photo = $request->file('logo');
                $url = $photo->store('asset/comunity', 'public');
            }
            $comunity = Comunity::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'logo' => $url,
            ]);
            $comunity->member()->create([
                'user_id' => $request->user()->id,
                'role' => 'moderator'
            ]);
            DB::commit();
            return ResponseFormated::success(null, 'data komunitas berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($url);
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg']
        ]);
        $url = null;
        try {
            DB::beginTransaction();
            $user = $request->user();
            $comunity = Comunity::whereHas('member', function ($q) use ($user) {
                $q->where('user_id', $user->id)->where('role', 'moderator');
            })->where('id', $id)->first();
            if (!$comunity) {
                return ResponseFormated::error(null, 'data komunitas tidak ditemukan', 404);
            }
            $url = $comunity->logo;
            if ($request->hasFile('logo')) {
                Storage::disk('public')->delete($url);
                $photo = $request->file('logo');
                $url = $photo->store('asset/comunity', 'public');
            }
            $comunity->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'logo' => $url,
            ]);
            DB::commit();
            return ResponseFormated::success(null, 'data komunitas berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormated::error(null, $e->getMessage(), 403);
        }
    }

    public function join(Request $request, $id)
    {
        $user = $request->user();
        $comunity = Comunity::where('id', $id)->first();

        if (!$comunity) {
            return ResponseFormated::error(null, 'Komunitas tidak ditemukan ', 403);
        }

        $member = Member::where('comunity_id', $id)->where('user_id', $user->id)->first();
        if ($member) {
            return ResponseFormated::error(null, 'anda sudah bergabung ke ' . $comunity->name, 403);
        }

        $comunity->member()->create([
            'user_id' => $request->user()->id,
            'role' => 'member'
        ]);

        return ResponseFormated::success(null, 'Berhasil bergabung ke komunitas');
    }

    public function leave(Request $request, $id)
    {
        $user = $request->user();
        $comunity = Comunity::where('id', $id)->first();

        if (!$comunity) {
            return ResponseFormated::error(null, 'Komunitas tidak ditemukan ', 403);
        }

        $member = Member::where('comunity_id', $id)->where('user_id', $user->id)->first();
        if (!$member) {
            return ResponseFormated::error(null, 'anda belum bergabung ke komunitas ' . $comunity->name, 403);
        }
        $jumlahMember = count($comunity->member);
        if ($jumlahMember === 1) {
            $url = $comunity->logo;
            if (!empty($url)) {
                Storage::disk('public')->delete($url);
            }
            $comunity->delete();
        }
        $member->delete();

        return ResponseFormated::success(null, 'Berhasil keluar dari komunitas');
    }
}
