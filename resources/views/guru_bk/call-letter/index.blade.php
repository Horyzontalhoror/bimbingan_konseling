@extends('layouts.app')

@section('title', 'Riwayat Surat Panggilan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Riwayat Surat Panggilan</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Daftar Surat Panggilan</strong>
                    <a href="{{ route('call-letter.form') }}" class="btn btn-primary btn-sm">+ Buat Surat Baru</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Keperluan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suratPanggilan as $index => $surat)
                                    <tr>
                                        <td>{{ $suratPanggilan->firstItem() + $index }}</td>
                                        <td>{{ $surat->student_name }}</td>
                                        <td>{{ $surat->class }}</td>
                                        <td>{{ $surat->wali_kelas }}</td>
                                        <td>{{ $surat->tanggal }}</td>
                                        <td>{{ $surat->keperluan }}</td>
                                        <td>
                                            <a href="{{ route('call-letter.show', $surat->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('call-letter.download', $surat->id) }}" class="btn btn-sm btn-secondary">Unduh</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada riwayat surat panggilan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $suratPanggilan->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Menampilkan {{ $suratPanggilan->firstItem() }} - {{ $suratPanggilan->lastItem() }} dari total {{ $suratPanggilan->total() }} Surat
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
