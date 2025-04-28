@extends('layouts.app')

@section('title', 'Data Pelanggaran')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Data Pelanggaran Siswa</h1>
    <a href="{{ route('violations.create') }}" class="btn btn-primary">+ Tambah Pelanggaran</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Telanggar</th>
            <th>Tanggal</th>
            <th>Tindakan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($violations as $violation)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $violation->student->name }}</td>
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
        @endforeach
    </tbody>
</table>

{{ $violations->links() }}
@endsection
