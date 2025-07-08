@extends('layouts.app')

@section('title', 'Riwayat Surat Panggilan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-history mr-2"></i>Riwayat Surat Panggilan</h1>
            <a href="{{ route('call-letter.form') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Buat Surat Baru</span>
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Daftar Surat yang Telah
                    Dibuat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Siswa & Kelas</th>
                                <th class="text-left">Wali Kelas</th>
                                <th>Tanggal Surat</th>
                                <th class="text-left">Keperluan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suratPanggilan as $index => $surat)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        <div class="font-weight-bold text-dark">{{ $surat->student->name ?? '-' }}</div>
                                        <small class="text-muted">Kelas: {{ $surat->student->class ?? '-' }}</small> |
                                        <small class="text-muted">NISN: {{ $surat->student->nisn ?? '-' }}</small>
                                    </td>
                                    <td class="text-left">{{ $surat->wali_kelas }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($surat->tanggal)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td class="text-left">{{ $surat->keperluan }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('call-letter.show', $surat->id) }}"
                                            class="btn btn-info btn-circle btn-sm" title="Lihat Detail Surat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('call-letter.destroy', $surat->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus riwayat surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm"
                                                title="Hapus Riwayat">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-gray-400 mb-3"></i>
                                        <h5 class="font-weight-bold">Belum Ada Riwayat Surat</h5>
                                        <p class="text-muted">Silakan buat surat panggilan baru untuk melihat riwayatnya di
                                            sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
