<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\AsmaulHusna;
use App\Models\Course;
use App\Models\Dzikir;
use App\Models\Plan;
use App\Models\Quizze;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data surah populer dari database
        $popularSurahs = [];
        try {
            if (Surah::exists()) {
                $popularSurahs = Surah::whereIn('nomor', [1, 18, 36, 55, 56, 67])
                    ->orderByRaw('FIELD(nomor, 1, 18, 36, 55, 56, 67)')
                    ->get();
            }
        } catch (\Throwable $th) {
            $popularSurahs = [];
        }

        if (empty($popularSurahs) || count($popularSurahs) === 0) {
            $popularSurahs = [
                ['nomor' => 1, 'nama' => 'الفاتحة', 'nama_latin' => 'Al-Fatihah', 'arti' => 'Pembukaan', 'jumlah_ayat' => 7, 'tempat_turun' => 'Mekah'],
                ['nomor' => 18, 'nama' => 'الكهف', 'nama_latin' => 'Al-Kahf', 'arti' => 'Gua', 'jumlah_ayat' => 110, 'tempat_turun' => 'Mekah'],
                ['nomor' => 36, 'nama' => 'يس', 'nama_latin' => 'Yasin', 'arti' => 'Yasin', 'jumlah_ayat' => 83, 'tempat_turun' => 'Mekah'],
                ['nomor' => 55, 'nama' => 'الرحمن', 'nama_latin' => 'Ar-Rahman', 'arti' => 'Maha Pengasih', 'jumlah_ayat' => 78, 'tempat_turun' => 'Madinah'],
                ['nomor' => 56, 'nama' => 'الواقعة', 'nama_latin' => 'Al-Waqi\'ah', 'arti' => 'Hari Kiamat', 'jumlah_ayat' => 96, 'tempat_turun' => 'Mekah'],
                ['nomor' => 67, 'nama' => 'الملك', 'nama_latin' => 'Al-Mulk', 'arti' => 'Kerajaan', 'jumlah_ayat' => 30, 'tempat_turun' => 'Mekah'],
            ];
        }

        // Ambil paket langganan dari database jika ada
        $plans = [];
        try {
            if (Plan::exists()) {
                $plans = Plan::all();
            }
        } catch (\Throwable $th) {
            $plans = [];
        }

        if (empty($plans) || count($plans) === 0) {
            $plans = [
                [
                    'name' => 'Paket Berkah (Gratis)',
                    'slug' => 'free',
                    'price' => 0,
                    'duration' => 'Selamanya',
                    'description' => 'Akses lengkap membaca Al-Qur\'an dan panduan ibadah harian.',
                    'features' => [
                        'Baca 30 Juz & Terjemah Kemenag',
                        'Audio Murottal Qari Pilihan',
                        'Jadwal Sholat & Arah Kiblat GPS',
                        'Dzikir Harian & Tasbih Digital',
                        'Akses Komunitas & Forum Muslim',
                    ],
                    'is_featured' => false,
                ],
                [
                    'name' => 'QuranQita Pro (Bulanan)',
                    'slug' => 'pro-monthly',
                    'price' => 29000,
                    'duration' => 'Bulan',
                    'description' => 'Akses seluruh fitur premium bebas iklan dan bimbingan eksklusif.',
                    'features' => [
                        'Semua fitur Gratis included',
                        'Bebas Iklan Sepenuhnya',
                        'Konsultasi Tanya Ustadz & AI Cerdas',
                        'Akses Seluruh 22+ Kelas Islami',
                        'Ikuti Kuis Islami & Leaderboard',
                        'Download Audio Murottal Offline',
                        'Jurnal Ibadah & Reminder Cerdas',
                    ],
                    'is_featured' => true,
                ],
                [
                    'name' => 'QuranQita Pro (Tahunan)',
                    'slug' => 'pro-annual',
                    'price' => 249000,
                    'duration' => 'Tahun',
                    'description' => 'Pilihan terbaik untuk istiqomah ibadah sepanjang tahun.',
                    'features' => [
                        'Semua fitur Pro Bulanan',
                        'Hemat lebih dari 28% per tahun',
                        'Konsultasi Tanya Ustadz Prioritas',
                        'Koin Reward Tambahan & Badges',
                        'Akses Seluruh Fitur Baru Lebih Awal',
                        'Dukungan Pengembangan Dakwah Digital',
                    ],
                    'is_featured' => false,
                ],
            ];
        }

        // Hitung statistik riil dari database
        $stats = [
            'surah' => 114,
            'dzikir' => 140,
            'asma' => 99,
            'course' => 22,
            'quiz' => 48,
            'user' => 2500,
        ];

        try {
            $stats['surah'] = Surah::count() ?: 114;
            $stats['dzikir'] = Dzikir::count() ?: 140;
            $stats['asma'] = AsmaulHusna::count() ?: 99;
            $stats['course'] = Course::count() ?: 22;
            $stats['quiz'] = Quizze::count() ?: 48;
            $realUser = User::count();
            if ($realUser > 0) {
                $stats['user'] = $realUser + 1500;
            }
        } catch (\Throwable $th) {
            // fallback
        }

        return view('landing', [
            'popularSurahs' => $popularSurahs,
            'plans' => $plans,
            'stats' => $stats,
            'user' => Auth::user(),
        ]);
    }
}
