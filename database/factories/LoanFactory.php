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

    public function definition(): array
    {
        $member = Member::inRandomOrder()->first();

        return [
            'member_id' => $member->id,
            'kode_peminjaman' => "PJM-",
            'judul_buku' => $this->faker->sentence(3),
            'tanggal_pinjam' => $this->faker->dateTimeBetween('-1 month', 'now')->format('d-m-Y'),
            'tanggal_jatuh_tempo' => $this->faker->dateTimeBetween('now', '+1 month')->format('d-m-Y'),
            'tanggal_kembali' => $this->faker->dateTimeBetween('now', '+1 month')->format('d-m-Y'),
            'status' => $this->faker->randomElement(['dipinjam', 'dikembalikan', 'terlambat']),
            'denda' => 0,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Loan $loan) {
            $loan->update([
                'kode_peminjaman' => 'PJM-' . $loan->id,
            ]);
        });
    }
}
