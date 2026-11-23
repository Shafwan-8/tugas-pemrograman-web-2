<x-app>

    <x-slot:title>
        {{ $title }}
    </x-slot:title>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('loans.index') }}" class="btn btn-primary">Kembali</a>
    </div>

    <div class="card border-1 bordered shadow-md mt-3">
        <div class="card-body">
            <form action="{{ route('loans.store') }}" method="POST">
                @csrf
                <div class="d-flex flex-row gap-3 justify-content-between mb-3">
                    <div class="mb-3 w-100">
                        <label for="member_id" class="form-label">Nama Peminjam</label>
                        <select class="form-control @error('member_id') is-invalid @enderror" id="member"
                            name="member_id">
                            <option value="" disabled selected>Pilih Nama Peminjam</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 w-100">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        <select class="form-control @error('judul_buku') is-invalid @enderror" id="judul_buku"
                            name="judul_buku">
                            <option value="" disabled selected>Pilih Buku</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->judul }}"
                                    {{ old('judul_buku') == $book->judul ? 'selected' : '' }}>
                                    {{ $book->judul }}
                                </option>
                            @endforeach
                        </select>

                        @error('judul_buku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="d-flex flex-row gap-3 justify-content-between mb-3">
                    <div class="mb-3 w-100">
                        <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                        <input type="date" class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror"
                            id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo"
                            value="{{ old('tanggal_jatuh_tempo') }}">

                        @error('tanggal_jatuh_tempo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    </form>
</x-app>
