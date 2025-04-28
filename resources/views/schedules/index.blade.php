@extends('layouts.app')

@section('title', 'Jadwal Konseling')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Jadwal Konseling</h1>
    <a href="{{ route('schedules.create') }}" class="btn btn-primary">+ Tambah Jadwal</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
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
        @foreach($schedules as $schedule)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $schedule->student->name }}</td>
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
        @endforeach
    </tbody>
</table>

{{ $schedules->links() }}
@endsection
