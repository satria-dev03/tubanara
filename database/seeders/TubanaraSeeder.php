<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TubanaraSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Sekolah Dummy
        DB::table('schools')->insert([
            ['name' => 'SDN Kutorejo 1', 'district_name' => 'Tuban', 'npsn' => '20504001', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SDN Ronggomulyo 2', 'district_name' => 'Tuban', 'npsn' => '20504002', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SDN Kebonsari 1', 'district_name' => 'Tuban', 'npsn' => '20504003', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SDN Sugiharjo 1', 'district_name' => 'Tuban', 'npsn' => '20504004', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SDN Jenu 1', 'district_name' => 'Jenu', 'npsn' => '20504005', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Data Konten Pembelajaran Dummy
        $contents = [
            [
                'title' => 'Pembelajaran Pecahan Menggunakan Media Pizza',
                'description' => 'Media interaktif berbentuk bundaran pizza untuk membantu pemahaman konsep dasar pecahan senilai pada murid kelas 4 SD.',
                'category' => 'Media Pembelajaran',
                'subject' => 'Matematika',
                'grade' => 'Kelas 4',
                'teacher_name' => 'Budi Santoso, S.Pd.',
                'school_name' => 'SDN Kutorejo 1',
                'district_name' => 'Tuban',
                'status' => 'PUBLISHED',
                'views_count' => 142,
                'downloads_count' => 38,
            ],
            [
                'title' => 'LKPD Eksplorasi Ekosistem Pesisir Pantai Tuban',
                'description' => 'Lembar Kerja Peserta Didik berbasis proyek observasi lingkungan pesisir pantai untuk mata pelajaran IPAS.',
                'category' => 'LKPD',
                'subject' => 'IPAS',
                'grade' => 'Kelas 5',
                'teacher_name' => 'Siti Aminah, M.Pd.',
                'school_name' => 'SDN Ronggomulyo 2',
                'district_name' => 'Tuban',
                'status' => 'PUBLISHED',
                'views_count' => 98,
                'downloads_count' => 45,
            ],
            [
                'title' => 'Modul Ajar Bahasa Indonesia: Membaca Nyaring Teks Narasi',
                'description' => 'Modul ajar kurikulum merdeka dilengkapi dengan instrumen asesmen membaca nyaring untuk siswa kelas 2 SD.',
                'category' => 'Modul',
                'subject' => 'Bahasa Indonesia',
                'grade' => 'Kelas 2',
                'teacher_name' => 'Eko Prasetyo, S.Pd.',
                'school_name' => 'SDN Kebonsari 1',
                'district_name' => 'Tuban',
                'status' => 'PUBLISHED',
                'views_count' => 210,
                'downloads_count' => 84,
            ],
            [
                'title' => 'Video Video Pembelajaran Tari Tradisional Tuban (Tari Thak-Thakan)',
                'description' => 'Video pengenalan kebudayaan lokal seni tari khas Tuban sebagai penguatan profil pelajar pancasila.',
                'category' => 'Video Pembelajaran',
                'subject' => 'Seni Budaya',
                'grade' => 'Kelas 3',
                'teacher_name' => 'Dewi Lestari, S.Pd.',
                'school_name' => 'SDN Jenu 1',
                'district_name' => 'Jenu',
                'status' => 'PUBLISHED',
                'views_count' => 315,
                'downloads_count' => 62,
            ],
        ];

        foreach ($contents as $c) {
            DB::table('contents')->insert(array_merge($c, [
                'slug' => Str::slug($c['title']),
                'license' => 'CC BY-NC-SA 4.0',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}