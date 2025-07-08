@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="h4">Dashboard Rekomendasi Siswa</h1>
        </div>
    </div>

    <div class="card p-4">
        <div class="row">

            <!-- KIRI -->
            <div class="col-md-4">
                <div class="card border-left-primary shadow mb-3">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Baik</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistik->firstWhere('kategori', 'Baik')->total ?? 0 }} Siswa
                        </div>
                    </div>
                </div>
                <div class="card border-left-warning shadow mb-3">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Cukup</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistik->firstWhere('kategori', 'Cukup')->total ?? 0 }} Siswa
                        </div>
                    </div>
                </div>
                <div class="card border-left-danger shadow">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Butuh Bimbingan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $statistik->firstWhere('kategori', 'Butuh Bimbingan')->total ?? 0 }} Siswa
                        </div>
                    </div>
                </div>
            </div>

            <!-- TENGAH: Chart -->
            <div class="col-md-4 d-flex align-items-center justify-content-center border shadow" style="height: 290px;">
                <canvas id="chartKategori" height="250"></canvas>
            </div>

            <!-- KANAN -->
            <div class="col-md-4">
                <div class="alert alert-info">
                    <h1 class="h5">Proses Clustering KMeans</h1>
                    <p class="text-muted">Mengelompokkan siswa berdasarkan kombinasi nilai, absen, dan pelanggaran.</p>
                    <a href="{{ route('keputusanAkhir') }}" class="btn btn-sm btn-primary mb-3">Proses Clustering</a>

                    <hr>

                    <h1 class="h5">Prediksi K-NN</h1>
                    <p class="text-muted">Menghasilkan prediksi kategori akhir berdasarkan tetangga terdekat.</p>
                    <a href="{{ route('keputusanAkhirKNN') }}" class="btn btn-warning btn-sm mb-3">Jalankan Prediksi K-NN</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Rekomendasi --}}
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-flask me-2"></i> Hasil Clustering dan Keputusan Akhir
            </h6>
        </div>
        {{-- Filter Pencarian --}}
        <form method="GET" class="row g-2 mb-3">
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

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-hover align-middle" width="100%">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>KMeans - Nilai</th>
                            <th>KMeans - Absen</th>
                            <th>KMeans - Pelanggaran</th>
                            <th>Keputusan Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $row)
                            <tr class="text-center">
                                <td class="text-left font-weight-bold text-dark">{{ $row->name }}</td>
                                <td>{{ $row->nisn }}</td>
                                <td>{{ $row->class }}</td>
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

        <div class="mt-3">
            {{ $siswa->links('pagination::bootstrap-4') }}
            <p class="text-muted">
                Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }} dari total
                {{ $siswa->total() }} Siswa
            </p>
        </div>

    </div>
@endsection

@push('scripts')
    @php
        $labels = $statistik->pluck('kategori');
        $values = $statistik->pluck('total');
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartKategori').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: {!! json_encode($values) !!},
                    backgroundColor: {!! json_encode(
                        $labels->map(function ($label) {
                            return $label === 'Baik' ? '#2ecc71' : ($label === 'Cukup' ? '#f1c40f' : '#e74c3c');
                        }),
                    ) !!}
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
@endpush
