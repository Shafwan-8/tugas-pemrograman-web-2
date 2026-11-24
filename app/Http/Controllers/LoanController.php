<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    private function perbaruiStatusDenda(Loan $loan)
    {
        $jatuhTempo = Carbon::parse($loan->tanggal_jatuh_tempo)->startOfDay();

        $acuan = $loan->tanggal_kembali
            ? Carbon::parse($loan->tanggal_kembali)->startOfDay()
            : today();

        $hariTerlambat = max(0, (int) $jatuhTempo->diffInDays($acuan, false));
        // dd($hariTerlambat);
        $loan->denda = $hariTerlambat * 1000;

        if ($loan->tanggal_kembali) {
            $loan->status = 'dikembalikan';
        } elseif ($hariTerlambat > 0) {
            $loan->status = 'terlambat';
        } else {
            $loan->status = 'dipinjam';
        }

        return $hariTerlambat;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::latest()->get();

        foreach ($loans as $loan) {
            $this->perbaruiStatusDenda($loan);
            $loan->save();
        }

        return view('loans.index', [
            'title' => 'Daftar Peminjaman Buku',
            'loans' => $loans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loans.create', [
            'title' => 'Tambah Peminjaman Buku',
            'members' => Member::all(),
            'books' => Book::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tanggalPinjam = now()->format('Y-m-d');

        $kodeTerakhir = Loan::latest('id')->first()->id;

        $kodePeminjaman = 'PJM-'.($kodeTerakhir + 1);
        // dd($kodePeminjaman);

        $request->merge(['kode_peminjaman' => $kodePeminjaman, 'tanggal_pinjam' => $tanggalPinjam]);

        $validatedData = $request->validate([
            'kode_peminjaman' => 'required',
            'member_id' => 'required',
            'judul_buku' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
        ],
            [
                'member_id.required' => 'Anggota harus dipilih.',
                'judul_buku.required' => 'Buku harus dipilih.',
                'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi.',
                'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus sama atau setelah tanggal hari ini.',
            ]);

        // dd($validatedData);
        Loan::create($validatedData);

        return to_route('loans.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        $hariTerlambat = $this->perbaruiStatusDenda($loan);
        $loan->save();

        return view('loans.show', [
            'title' => 'Detail Peminjaman',
            'loan' => $loan,
            'hariTerlambat' => $hariTerlambat,
            'dendaPerHari' => 1000,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        // dd($loan);
        return view('loans.edit', [
            'title' => 'Edit Peminjaman Buku',
            'loan' => $loan,
            'members' => Member::all(),
            'books' => Book::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $validatedData = $request->validate([
            'member_id' => 'required',
            'judul_buku' => 'required',
            'tanggal_jatuh_tempo' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
        ],
            [
                'member_id.required' => 'Anggota harus dipilih.',
                'judul_buku.required' => 'Buku harus dipilih.',
                'tanggal_jatuh_tempo.required' => 'Tanggal jatuh tempo harus diisi.',
                'tanggal_jatuh_tempo.after_or_equal' => 'Tanggal jatuh tempo harus sama atau setelah tanggal hari ini.',
            ]);

        $loan->update($validatedData);

        return to_route('loans.index')->with('success', 'Data Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        return to_route('loans.index')->with('success', 'Data Peminjaman berhasil dihapus.');
    }
}
