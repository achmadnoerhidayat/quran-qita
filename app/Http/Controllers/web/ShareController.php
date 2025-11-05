<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return redirect()->intended('/');
        }

        $intent = "intent://quranqita/video?id={$id}#Intent;scheme=quranqita;package=com.bsndev.quranqita;end";

        return view('redirect_intent', compact('intent'));
    }
}
