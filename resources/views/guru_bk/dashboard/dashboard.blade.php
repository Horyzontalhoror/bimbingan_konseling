@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Judul Halaman --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Rekomendasi Siswa</h1>
    </div>

    {{-- Statistik dan Prediksi K-NN --}}
    <div class="row">

        {{-- Statistik Cards --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Baik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik->firstWhere('kategori', 'Baik')->total ?? 0 }} Siswa
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-smile fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Cukup</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik->firstWhere('kategori', 'Cukup')->total ?? 0 }} Siswa
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-meh fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Butuh Bimbingan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $statistik->firstWhere('kategori', 'Butuh Bimbingan')->total ?? 0 }} Siswa
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-frown fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Prediksi K-NN Card (lebih informatif) --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Prediksi K-NN</div>
                        <p class="small text-gray-700 mb-2">
                            Tentukan rekomendasi kategori siswa berdasarkan data yang ada.
                        </p>
                    </div>
                    <form action="{{ route('keputusanAkhirKNN') }}" method="GET" class="text-center">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block"
                            onclick="return confirm('Proses ini akan menentukan keputusan akhir berdasarkan hasil 3 clustering K-Means. Lanjutkan?')">
                            <i class="fas fa-play mr-2"></i> Jalankan Prediksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- TABEL: Hasil Clustering dan Keputusan Akhir --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-flask me-2"></i> Hasil Clustering dan Keputusan Akhir
            </h6>
        </div>

        {{-- Filter Pencarian --}}
        <div class="card-body">
            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-3">
                    <input type="text" name="q" class="form-control" placeholder="Cari nama atau NISN..."
                        value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        <option value="Baik" {{ request('kategori') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup" {{ request('kategori') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="Butuh Bimbingan" {{ request('kategori') == 'Butuh Bimbingan' ? 'selected' : '' }}>
                            Butuh Bimbingan
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="kelas" class="form-control">
                        <option value="">Semua Kelas</option>
                        @foreach ($semuaKelas as $k)
                            <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>
                                {{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>

            {{-- Isi Tabel --}}
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered align-middle" width="100%"
                    cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Nilai</th>
                            <th>Absen</th>
                            <th>Pelanggaran</th>
                            <th>Keputusan Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $row)
                            <tr class="text-center">
                                <td class="text-left font-weight-bold text-dark">{{ $row->name }}</td>
                                <td>{{ $row->nisn }}</td>
                                <td>{{ $row->class }}</td>

                                {{-- Nilai --}}
                                <td>
                                    <span
                                        class="badge badge-pill px-3 py-2
                                        @if ($row->nilai === 'Baik') badge-success
                                        @elseif ($row->nilai === 'Cukup') badge-warning
                                        @elseif ($row->nilai === 'Butuh Bimbingan') badge-danger
                                        @else badge-secondary @endif">
                                        {{ $row->nilai }}
                                    </span>
                                </td>

                                {{-- Absen --}}
                                <td>
                                    <span
                                        class="badge badge-pill px-3 py-2
                                        @if ($row->absen === 'Rajin') badge-success
                                        @elseif ($row->absen === 'Cukup') badge-warning
                                        @elseif ($row->absen === 'Sering Absen') badge-danger
                                        @else badge-secondary @endif">
                                        {{ $row->absen }}
                                    </span>
                                </td>

                                {{-- Pelanggaran --}}
                                <td>
                                    <span
                                        class="badge badge-pill px-3 py-2
                                        @if ($row->pelanggaran === 'Tidak Pernah') badge-success
                                        @elseif ($row->pelanggaran === 'Ringan') badge-warning
                                        @elseif ($row->pelanggaran === 'Sering') badge-danger
                                        @else badge-secondary @endif">
                                        {{ $row->pelanggaran }}
                                    </span>
                                </td>

                                {{-- Keputusan Akhir --}}
                                <td>
                                    <span
                                        class="badge badge-pill px-3 py-2
                                        @if ($row->final === 'Baik') badge-success
                                        @elseif ($row->final === 'Cukup') badge-warning
                                        @elseif ($row->final === 'Butuh Bimbingan') badge-danger
                                        @else badge-secondary @endif">
                                        <i
                                            class="fas
                                            @if ($row->final === 'Baik') fa-check-circle
                                            @elseif ($row->final === 'Cukup') fa-exclamation-circle
                                            @elseif ($row->final === 'Butuh Bimbingan') fa-times-circle
                                            @else fa-info-circle @endif me-1"></i>
                                        {{ $row->final }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i> Tidak ada data rekomendasi siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="card-footer py-3 d-flex justify-content-between align-items-center">
            {{ $siswa->links('pagination::bootstrap-4') }}
            <p class="text-muted mb-0">
                Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }} dari total {{ $siswa->total() }} Siswa
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Karena chart dihapus, kita tidak lagi membutuhkan Chart.js di sini --}}
    {{-- Anda bisa menghapus push scripts ini sepenuhnya jika tidak ada script lain yang dibutuhkan --}}
    {{-- Atau biarkan kosong jika Anda berencana menambahkan script lain di masa mendatang --}}
@endpush
