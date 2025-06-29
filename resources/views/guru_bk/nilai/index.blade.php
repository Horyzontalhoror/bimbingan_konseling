@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Nilai Siswa</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Tabel Nilai Siswa</strong>
                    <div>
                        <a href="{{ route('nilai.export', request()->query()) }}" class="btn btn-success btn-sm">
                            Export ke Excel
                        </a>
                        <a href="{{ route('nilai.print', request()->query()) }}" class="btn btn-danger btn-sm">
                            Cetak PDF
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <input type="text" name="q" class="form-control" placeholder="Cari nama atau NISN..." value="{{ request('q') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="kategori" class="form-control">
                                <option value="">Semua Kategori</option>
                                <option value="Baik" {{ request('kategori') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Cukup" {{ request('kategori') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="Butuh Bimbingan" {{ request('kategori') == 'Butuh Bimbingan' ? 'selected' : '' }}>Butuh Bimbingan</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="kelas" class="form-control">
                                <option value="">Semua Kelas</option>
                                @foreach($semuaKelas as $kelas)
                                    <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary w-100" type="submit">Terapkan Filter</button>
                        </div>
                    </form>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                    <th>B. Indo</th>
                                    <th>B. Inggris</th>
                                    <th>Mate</th>
                                    <th>IPA</th>
                                    <th>IPS</th>
                                    <th>Agama</th>
                                    <th>PPKn</th>
                                    <th>Sosbud</th>
                                    <th>TIK</th>
                                    <th>Penjas</th>
                                    <th>Jumlah</th>
                                    <th>Rata-rata</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $s)
                                    <tr>
                                        <td>
                                            <a href="{{ route('nilai.edit', $s->id) }}">
                                                {{ $s->name }}
                                            </a>
                                        </td>
                                        <td>{{ $s->nisn }}</td>
                                        <td>{{ $s->class }}</td>
                                        <td>{{ $s->bindo }}</td>
                                        <td>{{ $s->bing }}</td>
                                        <td>{{ $s->mat }}</td>
                                        <td>{{ $s->ipa }}</td>
                                        <td>{{ $s->ips }}</td>
                                        <td>{{ $s->agama }}</td>
                                        <td>{{ $s->ppkn }}</td>
                                        <td>{{ $s->sosbud }}</td>
                                        <td>{{ $s->tik }}</td>
                                        <td>{{ $s->penjas }}</td>
                                        <td>{{ $s->jumlah_nilai }}</td>
                                        <td>{{ $s->rata_rata }}</td>
                                        {{-- <td>{{ number_format($s->rata_rata, 2) }}</td> --}}
                                        <td>
                                            <span class="badge
                                                @if($s->kategori == 'Baik') badge-success
                                                @elseif($s->kategori == 'Cukup') badge-warning
                                                @else badge-danger
                                                @endif">
                                                {{ $s->kategori }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="16" class="text-center">Belum ada data nilai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $data->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari total {{ $data->total() }} Siswa
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
