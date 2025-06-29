@extends('layouts.app')

@section('title', 'Algoritma')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Algoritma Klasifikasi</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header font-weight-bold text-primary">
                    Algoritma K-Means
                </div>
                <div class="card-body">
                    <p>Menampilkan proses atau hasil clustering K-Means di sini.</p>
                    <a href="{{ route('cluster') }}" class="btn btn-primary">Lihat Clustering</a>
                    <div>
                        @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                                myModal.show();
                            });
                        </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header font-weight-bold text-success">
                    Algoritma K-NN
                </div>
                <div class="card-body">
                    <p>Menampilkan prediksi K-Nearest Neighbors.</p>
                    <a href="{{ route('predict') }}" class="btn btn-success">Lihat Prediksi</a>
                    <div>
                        @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                                myModal.show();
                            });
                        </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="card shadow-sm">
        <!-- Card Header -->
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-sync-alt me-2 text-danger"></i> Reset Kategori
            </h5>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <p class="text-muted mb-4">
                Tindakan ini akan <strong>menghapus semua data kategori</strong> yang telah ditetapkan. Pastikan Anda yakin sebelum melanjutkan proses reset.
            </p>

            <!-- Form -->
            <form action="{{ route('algoritma.reset.knn') }}" method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin mereset kategori? Semua data akan dihapus!')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i> Reset Kategori
                </button>
            </form>
        </div>
    </div>
</div>

@include('guru_bk.algoritma.kmeans.kmeans')
@include('guru_bk.algoritma.knn.knn')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Hasil Perhitungan Algoritma</h1>
    <!-- KMeans -->

    <div class="row">
        <!-- KMeans -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Clustering K-Means</h6>
                </div>
                <div class="card-body">
                    @if (isset($kmeansResults) && count($kmeansResults))
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                    <th>Cluster</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <!-- KMeans -->
                                    @foreach ($kmeansResults->take(10) as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->nisn }}</td>
                                        <td>{{ $row->class }}</td>
                                        <td>
                                            <span class="badge
                                                @if($row->cluster == 'Baik') badge-success
                                                @elseif($row->cluster == 'Cukup') badge-warning
                                                @else badge-danger
                                                @endif">
                                                {{ $row->cluster }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Belum ada hasil clustering K-Means.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- KNN -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Prediksi K-Nearest Neighbors</h6>
                </div>
                <div class="card-body">
                    @if (isset($knnResults) && count($knnResults))
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                    <th>Prediksi Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <!-- KNN (hasil prediksi) -->
                                    @foreach ($knnResults->take(10) as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->nisn }}</td>
                                        <td>{{ $row->class }}</td>
                                        <td>
                                            <span class="badge
                                                @if($row->prediksi == 'Baik') badge-success
                                                @elseif($row->prediksi == 'Cukup') badge-warning
                                                @else badge-danger
                                                @endif">
                                                {{ $row->prediksi }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NISN</th>
                                    <th>Kategori</th>
                                    <th>Metode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hasilKNN as $data)
                                    <tr>
                                        <td>{{ $data->nisn }}</td>
                                        <td>{{ $data->kategori }}</td>
                                        <td>{{ $data->metode }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Belum ada hasil prediksi K-NN.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Belum ada hasil prediksi KNN.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <strong>Hasil Rekomendasi Siswa (Dari Tabel rekomendasi_siswa)</strong>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>NISN</th>
                    <th>Kategori</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekomendasi as $r)
                    <tr>
                        <td>{{ $r->nisn }}</td>
                        <td>{{ $r->kategori }}</td>
                        <td>{{ $r->metode }}</td>
                        <td>{{ $r->keterangan }}</td>
                        <td>{{ $r->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data rekomendasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

@if (session('success'))
<script>
    window.addEventListener('load', function () {
        const modalElement = document.getElementById('successModal');

        // Pastikan modal ditemukan
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            // Cek apakah modal sedang tersembunyi
            if (!modalElement.classList.contains('show')) {
                modal.show();
            }
        }
    });
</script>
@endif


<!-- Modal auto-show -->
@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var myModal = new bootstrap.Modal(document.getElementById('successModal'));
    myModal.show();
  });
</script>
@endif


{{-- @if (session('success'))
<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successModalLabel">
          <i class="fas fa-check-circle me-2"></i> Berhasil
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        {{ session('success') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endif --}}

@endsection
