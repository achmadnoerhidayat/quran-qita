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
        $key = config('services.google.key');
        $lokasi = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => $lat . ',' . $long,
            'key' => $key,
        ]);
        if ($lokasi->successful()) {
            $dataLokasi = $lokasi->json();
            $results = $dataLokasi['results'];
            if (!empty($results)) {
                $address = null;
                $addressComponents = $results[0]['address_components'];
                foreach ($addressComponents as $component) {
                    if (in_array('administrative_area_level_3', $component['types'])) {
                        $address = $component;
                    }
                }
                $response = [];
                $jadwal = $this->_jadwalSholat($lat, $long);
                $response['addrees'] = $address;
                $response['jadwal_sholat'] = $jadwal;
                return ResponseFormated::success($response, 'jadwal sholat berhasil ditambahkan');
            }
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
