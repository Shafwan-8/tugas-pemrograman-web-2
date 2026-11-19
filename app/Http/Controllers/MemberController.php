<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::latest()->get();

        $members->each(function ($member) {
            $member->alamat = Str::limit($member->alamat, 10);
        });

        return view('members.index', [
            'title' => 'Daftar Anggota Perpustakaan',
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create', [
            'title' => 'Tambah Anggota Perpustakaan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:members,email',
            'no_telepon' => 'required|string|max:13',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required',
        ],
        [
            'nama.required' => 'Nama anggota harus diisi.',
            'email.required' => 'Email anggota harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email anggota sudah digunakan.',
            'no_telepon.required' => 'No telepon anggota harus diisi.',
            'no_telepon.max' => 'No telepon anggota tidak boleh lebih dari 13 karakter.',
            'alamat.required' => 'Alamat anggota harus diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin anggota harus dipilih.',
        ]
        );

        Member::create($validatedData);

        return to_route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('members.show', [
            'title' => 'Detail Anggota',
            'member' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.edit', [
            'title' => 'Edit Anggota ',
            'member' => $member
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        if ($request->email === $member->email) {
            $validatedData = $request->validate([
                'nama' => 'required|string',
                'email' => 'required|email',
                'no_telepon' => 'required|string|max:13',
                'alamat' => 'required|string',
                'jenis_kelamin' => 'required',
            ],
            [
                'nama.required' => 'Nama anggota harus diisi.',
                'email.required' => 'Email anggota harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'no_telepon.required' => 'No telepon anggota harus diisi.',
                'no_telepon.max' => 'No telepon anggota tidak boleh lebih dari 13 karakter.',
                'alamat.required' => 'Alamat anggota harus diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin anggota harus dipilih.',
            ]
            );
        } else {
            $validatedData = $request->validate([
                'nama' => 'required|string',
                'email' => 'required|email|unique:members,email',
                'no_telepon' => 'required|string|max:13',
                'alamat' => 'required|string',
                'jenis_kelamin' => 'required',
            ],
            [
                'nama.required' => 'Nama anggota harus diisi.',
                'email.required' => 'Email anggota harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email anggota sudah digunakan.',
                'no_telepon.required' => 'No telepon anggota harus diisi.',
                'no_telepon.max' => 'No telepon anggota tidak boleh lebih dari 13 karakter.',
                'alamat.required' => 'Alamat anggota harus diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin anggota harus dipilih.',
            ]
            );
        }

        $member->update($validatedData);

        return to_route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return to_route('members.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
