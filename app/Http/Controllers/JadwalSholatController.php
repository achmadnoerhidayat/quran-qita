<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JadwalSholatController extends Controller
{
    public function index(Request $request)
    {
        $lat = $request->input('lat');
        $long = $request->input('long');
        if (!$lat && !$long) {
            return ResponseFormated::error(null, 'Latitude & Longitude Harus Diisi', 403);
        }
        $lokasi = Http::withHeaders([
            'User-Agent' => 'QuranQitaLaravelApp/1.0 (quranqita@gmail.com)' // pakai email asli
        ])->get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $lat,
            'lon' => $long,
        ]);
        if ($lokasi->successful()) {
            $dataLokasi = $lokasi->json();
            $response = [];
            $jadwal = $this->_jadwalSholat($lat, $long);
            $response['addrees'] = $dataLokasi['address'];
            $response['jadwal_sholat'] = $jadwal;
            return ResponseFormated::success($response, 'jadwal sholat berhasil ditambahkan');
        }
    }

    private function _jadwalSholat($lat, $long)
    {
        $date = Carbon::now()->format('d-m-Y');
        $jadwal = Http::get('https://api.aladhan.com/v1//timings/' . $date, [
            'latitude' => $lat,
            'longitude' => $long,
            'method' => 20,
        ]);
        if ($jadwal->successful()) {
            $dataSholat = $jadwal->json();
            return $dataSholat['data']['timings'];
        }
    }
}
