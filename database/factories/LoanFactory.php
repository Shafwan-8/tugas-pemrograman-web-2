<?php

namespace Database\Factories;

use App\Models\Book;
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
        $book = Book::inRandomOrder()->first();

        $tanggalPinjam = $this->faker->dateTimeBetween('-2 months', 'now');
        $jatuhTempo = (clone $tanggalPinjam)->modify('+7 days');
        $tanggalKembali = $this->faker->optional()->dateTimeBetween($tanggalPinjam, 'now');

        return [
            'member_id' => $member->id,
            'kode_peminjaman' => 'PJM-',
            'judul_buku' => $book->judul,
            'tanggal_pinjam' => $tanggalPinjam->format('Y-m-d'),
            'tanggal_jatuh_tempo' => $jatuhTempo->format('Y-m-d'),
            'tanggal_kembali' => $tanggalKembali?->format('Y-m-d'),
            'status' => 'dipinjam',
            'denda' => 0,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Loan $loan) {
            $loan->update([
                'kode_peminjaman' => 'PJM-'.$loan->id,
            ]);
        });
    }
}
