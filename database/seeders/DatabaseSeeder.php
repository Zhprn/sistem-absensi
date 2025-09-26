<?php

namespace Database\Seeders;

use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // !! Ubah APP_FAKER_LOCALE Yang Ada Di ENV menjadi id_ID
        // APP_FAKER_LOCALE=id_ID

        Pegawai::factory(5)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123'),
            'type' => '2',
        ]);

        $pegawais = pegawai::all();

        foreach ($pegawais as $pegawai) {
            // Buat email berdasarkan nama pegawai
            $email = strtolower(str_replace(' ', '', $pegawai->nama_pegawai)) . '@email.com';

            // Buat user baru
            $user = User::factory()->create([
                'name' => $pegawai->nama_pegawai,
                'email' => $email,
                'password' => bcrypt('password'), // Ganti dengan password yang diinginkan
                'type' => '0',
               
            ]);

            $pegawai->user_id = $user->id;
            $pegawai->save();

        }

        
    }
}
