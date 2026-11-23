<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin & User buat testing login
        User::firstOrCreate(
            ['email' => 'admin@avacrea.test'],
            [
                'username' => 'admin_avacrea',
                'name'     => 'Admin Avacrea',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@avacrea.test'],
            [
                'username' => 'creatanan',
                'name'     => 'Creator Hanan',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        // 2. Kategori Aset (slug dipakai untuk auto-naming: 1_hair, 1_clothes, dll)
        $categories = [
            ['name' => 'Background',      'slug' => 'background'],
            ['name' => 'Rambut Belakang', 'slug' => 'back_hair'],
            ['name' => 'Kulit',           'slug' => 'skin'],
            ['name' => 'Baju',            'slug' => 'clothes'],
            ['name' => 'Mata Kanan',      'slug' => 'right_eye'],
            ['name' => 'Mata Kiri',       'slug' => 'left_eye'],
            ['name' => 'Hidung',          'slug' => 'nose'],
            ['name' => 'Mulut',           'slug' => 'mouth'],
            ['name' => 'Poni',            'slug' => 'bangs'],
            ['name' => 'Aksesori 1',      'slug' => 'acc_1'],
            ['name' => 'Aksesori 2',      'slug' => 'acc_2'],
            ['name' => 'Aksesori 3',      'slug' => 'acc_3'],
        ];

        foreach ($categories as $cat) {
            AssetCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}