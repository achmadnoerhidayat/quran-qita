<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MasjidController extends Controller
{
    public function index(Request $request)
    {
        $lat = $request->input('lat');
        $long = $request->input('long');
        $radius = $request->input('radius');
        $type = $request->input('type');
        $keyword = $request->input('keyword');
        if (!$lat && !$long) {
            return ResponseFormated::error(null, 'Latitude & Longitude Harus Diisi', 403);
        }
        $key = config('services.google.key');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'location' =>  $lat . ', ' . $long,
            'radius' =>  $radius,
            'type' =>  $type,
            'keyword' =>  $keyword,
            'language' =>  'id',
            'region' =>  'ID',
            'key' =>  $key,
        ]);
        if ($response->successful()) {
            $data = $response->json();
            return ResponseFormated::success($data['results'], 'data lokasi masjid terdekat berhasil ditampilkan');
        }
    }

    public function beritaIslami(Request $request)
    {
        $id = $request->input('id');
        $page = $request->input('page', 1);
        if ($id) {
            $response = Http::get('https://artikel-islam.netlify.app/.netlify/functions/api/fir/detail/' . $id);
            if ($response->successful()) {
                $data = $response->json();
                return ResponseFormated::success($data['data'], 'data berita islami berhasil ditampilkan');
            }
        }

        $response = Http::get('https://artikel-islam.netlify.app/.netlify/functions/api/fir', [
            'page' => $page
        ]);
        if ($response->successful()) {
            $data = $response->json();
            return ResponseFormated::success($data['data'], 'data berita islami berhasil ditampilkan');
        }
    }
}
