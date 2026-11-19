<x-app>

    <x-slot:title>
        {{ $title }} <u>{{ $member->nama }}</u>
    </x-slot:title>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('members.index') }}" class="btn btn-primary">Kembali</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Informasi Anggota</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Nama</small>
                    <span>{{ $member->nama }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span>{{ $member->email }}</span>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <small class="text-muted d-block">Nomor Telepon</small>
                    <span>{{ $member->no_telepon }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Alamat</small>
                    <span>{{ $member->alamat }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Riwayat Peminjaman</h2>
            <span class="badge bg-secondary">{{ $member->loans->count() }} peminjaman</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Batas Pengembalian</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($member->loans as $loan)
                            <tr>
                                <td>{{ $loan->kode_peminjaman }}</td>
                                <td>{{ $loan->judul_buku }}</td>
                                <td>{{ $loan->tanggal_pinjam }}</td>
                                <td>{{ $loan->tanggal_jatuh_tempo }}</td>
                                <td>{{ $loan->tanggal_kembali ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ in_array($loan->status, ['dikembalikan']) ? 'bg-success' : (in_array($loan->status, ['terlambat']) ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ $loan->status}}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Anggota ini belum memiliki data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
