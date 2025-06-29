@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Hasil Perbandingan Rekomendasi</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Perbandingan Rekomendasi K-Means vs K-NN</strong>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Hasil KMeans</th>
                                <th>Hasil KNN</th>
                                <th>Final Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($siswa as $row)
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->nisn }}</td>
                                <td>{{ $row->class }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $row->kmeans ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $row->knn ?? '-' }}</span>
                                </td>
                                <td>
                                    @if ($row->knn == 'Butuh Bimbingan')
                                        <span class="badge badge-danger">Prioritas</span>
                                    @else
                                        <span class="badge badge-success">Tidak Prioritas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data siswa tersedia.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
