<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormated;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(Request $request, User $user)
    {
        $authUser = $request->user();
        if ($authUser->id === $user->id) {
            return ResponseFormated::error(null, 'Tidak bisa follow diri sendiri', 400);
        }

        $exists = Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->exists();

        if ($exists) {
            return ResponseFormated::error(null, 'Sudah mengikuti pengguna ini', 400);
        }

        Follow::create([
            'follower_id' => $authUser->id,
            'following_id' => $user->id,
        ]);

        return ResponseFormated::success(null, 'Berhasil follow ' . $user->name);
    }

    public function unfollow(Request $request, User $user)
    {
        $authUser = $request->user();

        $folow = Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)->first();

        if (!$folow) {
            return ResponseFormated::error(null, 'Belum mengikuti pengguna ini', 400);
        }

        Follow::where('follower_id', $authUser->id)
            ->where('following_id', $user->id)
            ->delete();


        return ResponseFormated::success(null, 'Berhasil unfollow ' . $user->name);
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->with(
            'follower:id,name,email,role,lat,long'
        )->get()
            ->pluck('follower');

        return ResponseFormated::success($followers, 'data follower berhasil ditampilkan');
    }

    public function following(User $user)
    {
        $following = $user->following()->with('following:id,name,email,role,lat,long')->get()
            ->pluck('following');

        return ResponseFormated::success($following, 'data following berhasil ditampilkan');
    }
}
