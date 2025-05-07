@extends('layouts.app')

@section('title', 'Jadwal Konseling')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Jadwal Konseling</h1>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Tabel Jadwal Konseling</strong>
                    <a href="{{ route('schedules.create') }}" class="btn btn-primary btn-sm">+ Tambah Jadwal</a>
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
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $index => $schedule)
                                    <tr>
                                        <td>{{ $schedules->firstItem() + $index }}</td>
                                        <td>{{ $schedule->student->name ?? '-' }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>{{ $schedule->time }}</td>
                                        <td>{{ $schedule->status }}</td>
                                        <td>
                                            <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data jadwal.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $schedules->links('pagination::bootstrap-4') }}
                        <p class="text-muted">
                            Menampilkan {{ $schedules->firstItem() }} - {{ $schedules->lastItem() }} dari total {{ $schedules->total() }} Jadwal
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
