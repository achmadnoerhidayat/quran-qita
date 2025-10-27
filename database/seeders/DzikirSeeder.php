<?php

namespace Database\Seeders;

use App\Models\Dzikir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DzikirSeeder extends Seeder
{
    private function getDzikir()
    {
        $response = Http::timeout(60)->retry(3, 1000)->get('https://muslim-api-three.vercel.app/v1/dzikir');
        if ($response->successful()) {
            $dataSurat = $response->json();
            foreach ($dataSurat['data'] as $sur) {
                Dzikir::create([
                    'type' => $sur['type'],
                    'arab' => $sur['arab'],
                    'indo' => $sur['indo'],
                    'ulang' => $sur['ulang'],
                ]);
                echo "Proses tambah data " . $sur['type'] . PHP_EOL;
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
        $this->getDzikir();
        echo 'Proses Seeding Selesai';
    }

    private function reset()
    {
        DB::table('dzikirs')->truncate();
    }
}
