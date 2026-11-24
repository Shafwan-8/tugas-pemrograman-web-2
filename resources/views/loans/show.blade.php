<x-app>
    <x-slot:title>
        {{ $title }} <u>{{ $loan->kode_peminjaman }}</u>
    </x-slot:title>

    {{-- @php
        $badgeStatus = match ($loan->status) {
            'dikembalikan' => 'bg-success',
            'terlambat' => 'bg-danger',
            default => 'bg-warning text-dark',
        };
    @endphp --}}

    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Kembali</a>
        <a href="{{ route('loans.edit', $loan) }}" class="btn btn-warning">Edit</a>
        
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Informasi Peminjaman</h2>
                    <span class="badge {{ $loan->status === 'dikembalikan' ? 'bg-success' : ($loan->status === 'terlambat' ? 'bg-danger' : 'bg-warning text-dark') }}">{{ $loan->status }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Kode Peminjaman</small>
                            <span class="badge bg-secondary">{{ $loan->kode_peminjaman }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Judul Buku</small>
                            <span>{{ $loan->judul_buku }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Tanggal Pinjam</small>
                            <span>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d-m-Y') }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block">Tanggal Jatuh Tempo</small>
                            <span>{{ \Carbon\Carbon::parse($loan->tanggal_jatuh_tempo)->format('d-m-Y') }}</span>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0">
                            <small class="text-muted d-block">Tanggal Kembali</small>
                            <span>
                                {{ $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d-m-Y') : '-' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge {{ $loan->status === 'dikembalikan' ? 'bg-success' : ($loan->status === 'terlambat' ? 'bg-danger' : 'bg-warning text-dark') }}">{{ $loan->status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100 {{ $hariTerlambat > 0 ? 'border-danger' : 'border-success' }}">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Rincian Denda</h2>
                </div>
                <div class="card-body">
                    @if ($hariTerlambat > 0)
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Hari terlambat</span>
                                <span>{{ $hariTerlambat }} hari</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Tarif per hari</span>
                                <span>Rp {{ number_format($dendaPerHari, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0 fw-bold">
                                <span>Total denda</span>
                                <span class="text-danger">Rp {{ number_format($loan->denda, 0, ',', '.') }}</span>
                            </li>
                        </ul>

                        @if ($loan->status === 'terlambat')
                            <div class="alert alert-warning small mb-0">
                                Buku belum dikembalikan. Denda masih berjalan dan akan bertambah setiap hari.
                            </div>
                        @endif
                    @else
                        <p class="h4 text-success mb-1">Rp 0</p>
                        <small class="text-muted">Tidak ada denda.</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Data Peminjam</h2>
            <a href="{{ route('members.show', $loan->member) }}" class="btn btn-sm btn-outline-primary">
                Lihat Detail Anggota
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Nama</small>
                    <span>{{ $loan->member->nama }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span>{{ $loan->member->email }}</span>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <small class="text-muted d-block">Nomor Telepon</small>
                    <span>{{ $loan->member->no_telepon }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Alamat</small>
                    <span>{{ $loan->member->alamat }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app>
