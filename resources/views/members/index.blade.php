<x-app>
    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('members.create') }}" class="btn btn-primary">Tambah Anggota</a>
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
                        <th class="text-center">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <td>{{ $member->nama }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->no_telepon }}</td>
                            <td>{{ $member->alamat }}</td>
                            <td>{{ $member->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning" role="button"
                                    title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
