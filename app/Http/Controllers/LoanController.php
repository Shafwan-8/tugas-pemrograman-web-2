<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loans.index', [
            'title' => 'Daftar Peminjaman Buku',
            'loans' => Loan::latest()->get()
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
            'books' => Book::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tanggalPinjam = now()->format('d-m-Y');

        $kodeTerakhir = Loan::latest('id')->first()->id;

        $kodePeminjaman = 'PMJ-' . $kodeTerakhir + 1;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
