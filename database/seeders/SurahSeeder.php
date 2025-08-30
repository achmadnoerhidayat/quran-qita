<?php

namespace Database\Seeders;

use App\Models\Ayat;
use App\Models\Surah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private function getSurah()
    {
        $response = Http::timeout(60)->retry(3, 1000)->get('https://equran.id/api/v2/surat');
        if ($response->successful()) {
            $dataSurat = $response->json();
            foreach ($dataSurat['data'] as $sur) {
                $surat = Surah::create([
                    'nomor' => $sur['nomor'],
                    'nama' => $sur['nama'],
                    'nama_latin' => $sur['namaLatin'],
                    'jumlah_ayat' => $sur['jumlahAyat'],
                    'tempat_turun' => $sur['tempatTurun'],
                    'arti' => $sur['arti'],
                    'deskripsi' => $sur['deskripsi'],
                    'audio_full' => $sur['audioFull'],
                ]);
                echo 'Proses tambah data ' . $sur['nama'];
                $response_ayah = Http::timeout(60)->retry(3, 1000)->get('https://equran.id/api/v2/surat/' . $sur['nomor']);
                if ($response_ayah->successful()) {
                    $data_ayah = $response_ayah->json()['data'];
                    foreach ($data_ayah['ayat'] as $ayat) {
                        Ayat::create([
                            'surah_id' => $surat->id,
                            'nomor_ayat' => $ayat['nomorAyat'],
                            'teks_arab' => $ayat['teksArab'],
                            'teks_latin' => $ayat['teksLatin'],
                            'teks_indo' => $ayat['teksIndonesia'],
                            'audio' => $ayat['audio'],
                        ]);
                        echo 'Proses tambah data ayat ' . $ayat['nomorAyat'];
                    }
                }
            }
        }
    }

    private function reset()
    {
        DB::table('surahs')->truncate();
        DB::table('ayats')->truncate();
    }

    public function run(): void
    {
        $this->reset();
        echo 'Proses Seeding Mulai';
        $this->getSurah();
        echo 'Proses Seeding Selesai';
    }
}
