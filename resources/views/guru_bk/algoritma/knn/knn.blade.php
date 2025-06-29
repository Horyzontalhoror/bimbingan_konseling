<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Konfigurasi dan Hasil Algoritma KNN</h1>
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
