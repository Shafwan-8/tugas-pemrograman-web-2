<?php

namespace App\Models;

use Database\Factories\LoanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'member_id',
    'kode_peminjaman',
    'judul_buku',
    'tanggal_pinjam',
    'tanggal_jatuh_tempo',
    'tanggal_kembali',
    'status',
    'denda',
])
]

class Loan extends Model
{
    /** @use HasFactory<LoanFactory> */
    use HasFactory;

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
