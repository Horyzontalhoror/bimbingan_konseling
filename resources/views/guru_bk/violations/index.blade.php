@extends('layouts.app')

@section('title', 'Data Pelanggaran')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Pelanggaran Siswa</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Tabel Pelanggaran</strong>
                    <a href="{{ route('violations.create') }}" class="btn btn-primary btn-sm">+ Tambah Pelanggaran</a>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Tindakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($violations as $index => $violation)
                                    <tr>
                                        <td>{{ $violations->firstItem() + $index }}</td>
                                        <td>{{ $violation->student->name ?? '-' }}</td>
                                        <td>{{ $violation->type }}</td>
                                        <td>{{ $violation->date }}</td>
                                        <td>{{ $violation->action }}</td>
                                        <td>
                                            <a href="{{ route('violations.edit', $violation) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('violations.destroy', $violation) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data pelanggaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $violations->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Menampilkan {{ $violations->firstItem() }} - {{ $violations->lastItem() }} dari total {{ $violations->total() }} Pelanggaran
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
