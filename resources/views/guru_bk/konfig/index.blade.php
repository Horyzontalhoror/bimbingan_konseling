@extends('layouts.app')

@section('title', 'Konfigurasi Centroid K-Means')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Konfigurasi Centroid K-Means</h1>

        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">Daftar Konfigurasi Centroid</h6>
            </div>

            @php
                // Kelompokkan berdasarkan nama_centroid
                $centroids = collect($data)->groupBy('nama_centroid');
            @endphp

            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Centroid</th>
                            <th>Nilai</th>
                            <th>Absen</th>
                            <th>Pelanggaran</th>
                            <th>Kategori</th>
                            <th>Dibuat</th>
                            <th>Diubah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($centroids as $nama => $group)
                            @php
                                // Ambil data berdasarkan tipe
                                $nilai = $group->firstWhere('tipe', 'nilai');
                                $absen = $group->firstWhere('tipe', 'absen');
                                $pelanggaran = $group->firstWhere('tipe', 'pelanggaran');
                            @endphp
                            <tr>
                                <td>{{ $nilai?->id ?? ($absen?->id ?? $pelanggaran?->id) }}</td>
                                <td>
                                    <a href="{{ route('konfigurasi.edit', $nilai?->id ?? ($absen?->id ?? $pelanggaran?->id)) }}"
                                        class="text-primary font-weight-bold">
                                        {{ $nama }}
                                    </a>
                                </td>
                                <td>{{ $nilai ? number_format($nilai->centroid, 2) : '-' }}</td>
                                <td>{{ $absen ? number_format($absen->centroid, 2) : '-' }}</td>
                                <td>{{ $pelanggaran ? number_format($pelanggaran->centroid, 2) : '-' }}</td>
                                <td>
                                    <span
                                        class="badge
                                        @if (($nilai?->kategori ?? '') === 'Baik') badge-success
                                        @elseif(($nilai?->kategori ?? '') === 'Cukup') badge-warning
                                        @else badge-danger @endif">
                                        {{ $nilai->kategori ?? ($absen->kategori ?? ($pelanggaran->kategori ?? '-')) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($nilai?->created_at ?? ($absen?->created_at ?? $pelanggaran?->created_at))->format('d-m-Y H:i') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($nilai?->updated_at ?? ($absen?->updated_at ?? $pelanggaran?->updated_at))->format('d-m-Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('konfigurasi.edit', $nilai?->id ?? ($absen?->id ?? $pelanggaran?->id)) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data konfigurasi centroid.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong>Konfigurasi Centroid (Tabel: konfigurasi_kmeans)</strong>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Centroid</th>
                            <th>Tipe</th>
                            <th>Nilai Centroid</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($konfigurasiKMeans as $item)
                            <tr>
                                <td>{{ $item->nama_centroid }}</td>
                                <td>{{ ucfirst($item->tipe) }}</td>
                                <td>{{ $item->centroid }}</td>
                                {{-- <td>{{ $item->kategori }}</td> --}}
                                <td>
                                    <span
                                        class="badge
                                        @if (in_array($item?->kategori ?? '', ['Baik', 'Rajin', 'Tidak Pernah'])) badge-success
                                        @elseif (in_array($item?->kategori ?? '', ['Cukup','Ringan']))
                                            badge-warning
                                        @else
                                            badge-danger @endif">
                                        {{ $item->kategori ?? ($absen->kategori ?? ($pelanggaran->kategori ?? '-')) }}
                                    </span>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada konfigurasi centroid.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
