<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Konfigurasi dan Hasil Algoritma K-Means</h1>
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

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                <strong>Konfigurasi Centroid KMeans</strong>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama Centroid</th>
                            <th>Nilai Rata-rata Centroid</th>
                            <th>Kategori</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($konfigurasiKMeans as $c)
                            <tr>
                                <td>{{ $c->nama_centroid }}</td>
                                <td><a href="{{ route('algoritma.kmeans.edit', $c->id) }}">{{ $c->nilai_centroid }}</a></td>
                                <td>
                                    <span class="badge
                                        @if($c->kategori == 'Baik') badge-success
                                        @elseif($c->kategori == 'Cukup') badge-warning
                                        @else badge-danger
                                        @endif">
                                        {{ $c->kategori }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($c->created_at)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada konfigurasi centroid tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
