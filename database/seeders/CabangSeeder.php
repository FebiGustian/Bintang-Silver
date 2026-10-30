<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CabangSeeder extends Seeder
{
    public function run(): void
    {
        $cabangs = [
            ['BLT', 'Baltos', 'Jawa Barat'],
            ['ITC', 'ITC', 'Jawa Barat'],
            ['CMD', 'Cimindi', 'Jawa Barat'],
            ['BTJ', 'Batujajar', 'Jawa Barat'],
            ['LMB', 'Lembang', 'Jawa Barat'],
            ['MIM', 'MIM', 'Jawa Barat'],
            ['MKO', 'Miko', 'Jawa Barat'],
            ['PPH', 'Plaza Parahyangan', 'Jawa Barat'],
            ['PSK', 'Pasir Koja', 'Jawa Barat'],
            ['LEK', 'Lippo Ekalokasari Bogor', 'Jawa Barat'],
            ['BXS', 'Boxies Mall Bogor', 'Jawa Barat'],
            ['PGC', 'PGC Cililitan', 'Jakarta'],
            ['ICM', 'ITC Cempaka Mas', 'Jakarta'],
        ];

        $kodes = array_column($cabangs, 0);

        foreach ($cabangs as [$kode, $nama, $wilayah]) {
            DB::table('cabangs')->updateOrInsert(
                ['kode_cabang' => $kode],
                [
                    'nama_cabang' => $nama,
                    'wilayah' => $wilayah,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        DB::table('cabangs')->whereNotIn('kode_cabang', $kodes)->delete();

        $baltosId = DB::table('cabangs')->where('kode_cabang', 'BLT')->value('id');

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@bintangsilver.test'],
            [
                'name' => 'Admin Pusat',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'cabang_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'staff.baltos@bintangsilver.test'],
            [
                'name' => 'Staff Baltos',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'cabang_id' => $baltosId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
