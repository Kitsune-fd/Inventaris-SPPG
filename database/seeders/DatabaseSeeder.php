<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('123')
            ]
        );

        // Data dummy dinonaktifkan agar sistem siap dari kondisi awal yang bersih.
        // Uncomment jika memerlukan data dummy pengujian di kemudian hari:
        // $this->call([
        //     KategoriSeeder::class,
        //     BahanBakuSeeder::class,
        //     SekolahSeeder::class,
        // ]);
    }
}
