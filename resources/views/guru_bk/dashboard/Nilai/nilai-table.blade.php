<div class="card-body">
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <input wire:model.debounce.500ms="q" type="text" class="form-control" placeholder="Cari nama atau NISN...">
        </div>

        <div class="col-md-3">
            <select wire:model="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                <option value="Baik">Baik</option>
                <option value="Cukup">Cukup</option>
                <option value="Butuh Bimbingan">Butuh Bimbingan</option>
            </select>
        </div>

        <div class="col-md-3">
            <select wire:model="kelas" class="form-control">
                <option value="">Semua Kelas</option>
                @foreach($semuaKelas as $kelas)
                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>NISN</th>
                    <th>Rata-Rata</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                    <tr>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->class }}</td>
                        <td>{{ $row->nisn }}</td>
                        <td>{{ $row->rata_rata }}</td>
                        <td>
                            @if ($row->kategori == 'Butuh Bimbingan')
                                <span class="badge bg-danger text-white">{{ $row->kategori }}</span>
                            @elseif ($row->kategori == 'Cukup')
                                <span class="badge bg-warning text-dark">{{ $row->kategori }}</span>
                            @else
                                <span class="badge bg-success">{{ $row->kategori }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $data->links() }}
    </div>
</div>
