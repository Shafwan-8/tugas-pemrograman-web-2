<x-app>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <div class="d-flex justify-content-end mb-3">
        <a href="#" class="btn btn-primary">Tambah Peminjaman</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-1 bordered shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Kode</th>
                        <th>Judul Buku</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <th class="text-center">
                                <span class="badge bg-secondary text-white">{{ $loan->kode_peminjaman }}</span>
                            </th>
                            <td>{{ $loan->judul_buku }}</td>
                            <td>{{ $loan->member->nama }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>
                                <span
                                    class="badge {{ in_array($loan->status, ['dikembalikan']) ? 'bg-success' : (in_array($loan->status, ['terlambat']) ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $loan->status }}
                                </span>
                            </td>
                            <td>{{ $loan->denda }}</td>
                            <td class="text-center text-nowrap">
                                -
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
