@extends('layouts.app')

@section('title', 'Algoritma Klasifikasi')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cogs mr-2"></i>Algoritma Klasifikasi & Rekomendasi</h1>
        </div>

        <!-- Panel Kontrol Algoritma -->
        <div class="row">
            <!-- K-Means Clustering -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-project-diagram mr-2"></i>Proses K-Means Clustering
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Kelompokkan siswa ke dalam 3 cluster (Baik, Cukup, Butuh Bimbingan)
                            berdasarkan masing-masing kriteria.
                        </p>

                        <div class="list-group">
                            <!-- K-Means Nilai -->
                            <form action="{{ route('kmeans.nilai') }}" method="POST"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                onsubmit="return confirm('Anda yakin ingin menjalankan clustering K-Means berdasarkan NILAI?')">
                                @csrf
                                <div>
                                    <h6 class="mb-1 font-weight-bold">K-Means Berdasarkan Nilai</h6>
                                    <small>Mengelompokkan siswa berdasarkan rata-rata nilai akademik.</small>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                    title="Proses Nilai" {{ session('kmeans.completed') ? 'disabled' : '' }}>
                                    <i class="fas fa-chart-line"></i>
                                </button>
                            </form>

                            <!-- K-Means Absensi -->
                            <form action="{{ route('kmeans.absen') }}" method="POST"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                onsubmit="return confirm('Anda yakin ingin menjalankan clustering K-Means berdasarkan ABSENSI?')">
                                @csrf
                                <div>
                                    <h6 class="mb-1 font-weight-bold">K-Means Berdasarkan Absensi</h6>
                                    <small>Mengelompokkan siswa berdasarkan total ketidakhadiran.</small>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                    title="Proses Absensi" {{ session('kmeans.completed') ? 'disabled' : '' }}>
                                    <i class="fas fa-user-clock"></i>
                                </button>
                            </form>

                            <!-- K-Means Pelanggaran -->
                            <form action="{{ route('kmeans.pelanggaran') }}" method="POST"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                onsubmit="return confirm('Anda yakin ingin menjalankan clustering K-Means berdasarkan PELANGGARAN?')">
                                @csrf
                                <div>
                                    <h6 class="mb-1 font-weight-bold">K-Means Berdasarkan Pelanggaran</h6>
                                    <small>Mengelompokkan siswa berdasarkan total poin pelanggaran.</small>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" data-toggle="tooltip"
                                    title="Proses Pelanggaran" {{ session('kmeans.completed') ? 'disabled' : '' }}>
                                    <i class="fas fa-gavel"></i>
                                </button>
                            </form>
                        </div>

                        <hr>

                        <!-- Finalisasi K-Means -->
                        <form action="{{ route('kmeans.final') }}" method="POST" class="text-center"
                            onsubmit="return confirm('Proses ini akan menentukan keputusan akhir berdasarkan hasil 3 clustering K-Means. Lanjutkan?')">
                            @csrf
                            <button class="btn btn-warning btn-icon-split"
                                {{ !session('kmeans.ready') || session('kmeans.completed') ? 'disabled' : '' }}>
                                <span class="icon text-white-50"><i class="fas fa-check-double"></i></span>
                                <span class="text">Tentukan Keputusan Akhir K-Means</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- K-NN Classification -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-crosshairs mr-2"></i>Proses K-NN Classification
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Prediksi kategori siswa menggunakan data latih yang ada dengan algoritma
                            K-Nearest Neighbors.</p>
                        <div class="text-center mt-5 mb-5">
                            <a href="{{ route('keputusanAkhirKNN') }}" class="btn btn-success btn-icon-split btn-lg"
                                onclick="return confirm('Proses ini akan melakukan voting dari hasil 3 klasifikasi K-NN untuk menentukan prediksi akhir. Lanjutkan?')"
                                data-toggle="tooltip" title="Lakukan voting dari hasil KNN Nilai, Absen, dan Pelanggaran">
                                <span class="icon text-white-50"><i class="fas fa-vote-yea"></i></span>
                                <span class="text">Jalankan Prediksi Akhir K-NN</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Reset -->
        <div class="card shadow mb-4 border-left-danger">
            <div class="card-header py-3 bg-danger text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-sync-alt mr-2"></i>Reset Data Algoritma
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Gunakan tombol ini untuk menghapus semua data hasil proses algoritma (kategori dan prediksi) dari
                    database.
                    Tindakan ini tidak dapat dibatalkan dan perlu dilakukan jika ada pembaruan data siswa yang signifikan.
                </p>

                <form action="{{ route('algoritma.reset.kategori') }}" method="POST"
                    onsubmit="return confirm('PERINGATAN! Anda akan menghapus semua hasil K-Means dan K-NN. Apakah Anda benar-benar yakin?')">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50"><i class="fas fa-exclamation-triangle"></i></span>
                        <span class="text">Reset Semua Kategori & Prediksi</span>
                    </button>
                </form>

                @if (session('success') && session('success') === 'Berhasil direset.')
                    <div class="alert alert-success mt-4 mb-0">
                        <i class="fas fa-check-circle mr-2"></i>
                        Semua data hasil proses algoritma berhasil direset. Anda sekarang bisa menjalankan ulang proses
                        K-Means.
                    </div>
                @endif
            </div>
        </div>

        <!-- Hasil Rekomendasi -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-list mr-2"></i>Hasil Rekomendasi
                    Siswa</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Metode</th>
                                <th>Keterangan</th>
                                <th>Tanggal Proses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekomendasi as $index => $r)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $r->name ?? 'N/A' }}</td> <!-- karena sudah digabung -->
                                    <td>{{ $r->nisn }}</td>
                                    <td class="text-center">
                                        @if ($r->kategori == 'Baik')
                                            <span class="badge badge-success">Baik</span>
                                        @elseif($r->kategori == 'Cukup')
                                            <span class="badge badge-warning">Cukup</span>
                                        @else
                                            <span class="badge badge-danger">Butuh Bimbingan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($r->metode == 'K-Means')
                                            <span class="badge badge-primary">K-Means</span>
                                        @else
                                            <span class="badge badge-success">K-NN</span>
                                        @endif
                                    </td>
                                    <td>{{ $r->keterangan }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($r->created_at)->isoFormat('D MMM Y, HH:mm') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-info-circle fa-3x text-gray-400 mb-3"></i>
                                        <h5 class="font-weight-bold">Belum Ada Data Rekomendasi</h5>
                                        <p class="text-muted">Jalankan salah satu proses algoritma di atas untuk melihat
                                            hasilnya di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Notifikasi Sukses -->
    @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-left-success">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-success" id="successModalLabel"><i
                                class="fas fa-check-circle mr-2"></i>Proses Berhasil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi Tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Tampilkan modal jika ada session 'success'
            @if (session('success'))
                $('#successModal').modal('show');
            @endif
        });
    </script>
@endpush
