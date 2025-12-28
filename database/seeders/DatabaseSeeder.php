<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\KategoriIuran;
use App\Models\User;
use App\Models\Warga;
use App\Models\AnggotaKeluarga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan IuranSeeder
        $this->call(IuranSeeder::class);

        // 2. Buat Akun Admin Default
        $adminUser = User::create([
            'name' => 'Admin RT35',
            'email' => 'admin@simpleakunting.my.id',
            'password' => Hash::make('WargaConnect2025!'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'status' => 'verified', // Explicitly verify admin
        ]);

        // 3. Buat Data Profil Warga untuk Admin
        Warga::create([
            'user_id' => $adminUser->id,
            'nama_lengkap' => 'Admin WargaConnect',
            'nik' => '0000000000000000',
            'no_kk' => '0000000000000000',
            'tempat_lahir' => 'Sesuai Domisili',
            'tanggal_lahir' => '1990-01-01',
            'alamat_rumah' => 'Kantor RT 35',
            'status_verifikasi' => 'verified',
        ]);

        // 4. Create 5 Dummy Residents (for testing)
        $satpam = \App\Models\KategoriIuran::where('nama_iuran', 'Iuran Keamanan')->first();
        
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Warga {$i}",
                'email' => "warga{$i}@rt35.warga",
                'password' => Hash::make('password'),
                'role' => 'warga',
                'status' => 'verified',
            ]);

            $warga = Warga::create([
                'user_id' => $user->id,
                'nama_lengkap' => "Warga {$i}",
                'nik' => '320100000000000' . $i,
                'no_kk' => '320100000000009' . $i,
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-01-01',
                'alamat_rumah' => "Jalan Mawar No. {$i}",
                'status_verifikasi' => 'verified',
            ]);

            // Add Family Members
            AnggotaKeluarga::create([
                'warga_id' => $warga->id,
                'nama_lengkap' => "Istri Warga {$i}",
                'nik' => '320100000000001' . $i,
                'hubungan_keluarga' => 'Istri',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1987-05-12',
            ]);

            // Create some past bills
            if ($satpam) {
                Bill::create([
                    'user_id' => $user->id,
                    'kategori_iuran_id' => $satpam->id,
                    'month' => Carbon::now()->subMonth()->month,
                    'year' => Carbon::now()->subMonth()->year,
                    'amount' => $satpam->nominal,
                    'status' => 'paid',
                    'due_date' => Carbon::now()->subMonth()->startOfMonth()->addDays(10),
                ]);

                Bill::create([
                    'user_id' => $user->id,
                    'kategori_iuran_id' => $satpam->id,
                    'month' => Carbon::now()->month,
                    'year' => Carbon::now()->year,
                    'amount' => $satpam->nominal,
                    'status' => 'unpaid',
                    'due_date' => Carbon::now()->startOfMonth()->addDays(10),
                ]);
            }
        }

        // 5. Create dummy announcements
        \App\Models\Announcement::create([
            'title' => 'Kerja Bakti Minggu Ini',
            'content' => 'Dimohon kehadiran seluruh warga untuk kerja bakti membersihkan selokan pada hari Minggu jam 07:00 WIB.',
            'is_active' => true,
        ]);

        \App\Models\Announcement::create([
            'title' => 'Jadwal Pemadaman Listrik',
            'content' => 'PLN akan melakukan pemeliharaan jaringan listrik pada hari Senin, 30 Desember 2024 pukul 09:00-15:00 WIB. Mohon warga mempersiapkan diri.',
            'is_active' => true,
        ]);

        \App\Models\Announcement::create([
            'title' => 'Rapat Warga Bulanan',
            'content' => 'Mengundang seluruh warga RT 35 untuk menghadiri rapat bulanan yang akan dilaksanakan pada hari Sabtu, 4 Januari 2025 pukul 19:30 WIB di Balai RT.',
            'is_active' => true,
        ]);
    }
}
