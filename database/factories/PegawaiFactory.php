<?php

namespace Database\Factories;

use App\Models\Shift;
use App\Models\Bagian;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('################'), // 16 digit angka unik
            'nama_pegawai' => fake()->name(),
            'alamat' => fake()->sentence(3),
            'gender' => fake()->numberBetween(0, 1), // biasanya 0 = laki-laki, 1 = perempuan
            'tgl_lahir' => fake()->date(),
            'jabatan_id' => Jabatan::factory(),
            'bagian_id' => Bagian::factory(),
            'shift_id' => Shift::factory(),
            'foto' => null,
            'user_id' => null,
        ];
    }
}
