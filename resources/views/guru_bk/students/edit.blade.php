@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="mb-4">
    <h1 class="h4">Edit Data Siswa</h1>
</div>

<form action="{{ route('students.update', $student) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
    </div>
    <div class="mb-3">
        <label>NISN</label>
        <input type="text" name="nisn" class="form-control" value="{{ $student->nisn }}" required>
    </div>
    <div class="mb-3">
        <label>Kelas</label>
        <input type="text" name="class" class="form-control" value="{{ $student->class }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
