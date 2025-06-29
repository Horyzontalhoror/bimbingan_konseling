@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Tabel Data Siswa</strong>
                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Filter Form -->
                    <form method="GET">
                        <div class="row align-items-end mb-3">
                            <div class="col-md-4">
                                <input type="text" name="q" id="q" class="form-control" placeholder="Ketik nama atau NISN..." value="{{ request('q') }}">
                            </div>

                            <div class="col-md-4">
                                <select name="kelas" id="kelas" class="form-control">
                                    <option value="">Semua Kelas</option>
                                    @foreach($semuaKelas as $kelas)
                                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $student)
                                    <tr>
                                        <td>{{ $students->firstItem() + $index }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->nisn }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td>
                                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data siswa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $students->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Menampilkan {{ $students->firstItem() }} - {{ $students->lastItem() }} dari total {{ $students->total() }} Siswa
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
