@extends('layouts.app')

@section('title', 'Tambah Pelanggaran')

@section('content')
<div class="mb-4">
    <h1 class="h4">Tambah Data Pelanggaran</h1>
</div>

<form action="{{ route('violations.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Siswa</label>
        <select name="student_id" class="form-control" required>
            <option value="">Pilih Siswa</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jenis Pelanggaran</label>
        <input type="text" name="type" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Tindakan</label>
        <input type="text" name="action" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('violations.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
