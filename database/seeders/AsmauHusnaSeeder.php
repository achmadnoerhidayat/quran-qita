<?php

namespace Database\Seeders;

use App\Models\AsmaulHusna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AsmauHusnaSeeder extends Seeder
{
    private function getAsma()
    {
        $response = Http::timeout(60)->retry(3, 1000)->get('https://muslim-api-three.vercel.app/v1/quran/asma');
        if ($response->successful()) {
            $dataSurat = $response->json();
            foreach ($dataSurat['data'] as $sur) {
                AsmaulHusna::create([
                    'arab' => $sur['arab'],
                    'latin' => $sur['latin'],
                    'indo' => $sur['indo']
                ]);
                echo "Proses tambah data " . $sur['latin'] . PHP_EOL;
            }
        }
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->reset();
        echo 'Proses Seeding Mulai';
        $this->getAsma();
        echo 'Proses Seeding Selesai';
    }

    private function reset()
    {
        DB::table('asmaul_husnas')->truncate();
    }
}
