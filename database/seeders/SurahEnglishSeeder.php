<?php

namespace Database\Seeders;

use App\Models\Ayat;
use App\Models\Surah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class SurahEnglishSeeder extends Seeder
{
    private function getSurah()
    {
        $response = Http::timeout(60)->retry(3, 1000)->get('https://equran.id/api/en/surah');
        if ($response->successful()) {
            $dataSurat = $response->json();
            foreach ($dataSurat['data'] as $sur) {
                $surat = Surah::where('nomor', $sur['number'])->first();
                if ($surat) {
                    $surat->update([
                        'arti_english' => $sur['englishNameTranslation']
                    ]);
                    echo "Proses update data surat: {$sur['englishName']}" . PHP_EOL;
                    $response_ayah = Http::timeout(60)->retry(3, 1000)->get('https://equran.id/api/en/surah/' . $sur['number']);
                    if ($response_ayah->successful()) {
                        $data_ayah = $response_ayah->json()['data'];
                        foreach ($data_ayah['ayahs'] as $ayat) {
                            $ayah = Ayat::where('surah_id', $surat->id)->where('nomor_ayat', $ayat['numberInSurah'])->first();
                            if ($ayah) {
                                $ayah->update([
                                    'teks_english' => $ayat['textEnglish']
                                ]);
                                echo "Proses update data ayat {$ayat['numberInSurah']}" . PHP_EOL;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Proses Seeding Mulai" . PHP_EOL;
        $this->getSurah();
        echo "Proses Seeding Selesai" . PHP_EOL;
    }
}
