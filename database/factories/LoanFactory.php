<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static int $urutan = 0;

    public function definition(): array
    {
    
        return [
            'member_id' => Member::inRandomOrder()->first()->id,
            'kode_peminjaman' => now()->format('ymd') . '-' . ++static::$urutan,
            'judul_buku' => $this->faker->sentence(3),
            'tanggal_pinjam' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'tanggal_jatuh_tempo' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'tanggal_kembali' => $this->faker->optional()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['dipinjam', 'dikembalikan', 'terlambat']),
            'denda' => 0,
        ];
    }
}
