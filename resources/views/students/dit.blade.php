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
        <label>NIS</label>
        <input type="text" name="nis" class="form-control" value="{{ $student->nis }}" required>
    </div>
    <div class="mb-3">
        <label>Kelas</label>
        <input type="text" name="class" class="form-control" value="{{ $student->class }}" required>
    </div>
    <div class="mb-3">
        <label>Jenis Kelamin</label>
        <select name="gender" class="form-control" required>
            <option value="">Pilih</option>
            <option value="Laki-laki" {{ $student->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ $student->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="address" class="form-control">{{ $student->address }}</textarea>
    </div>
    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="birth_date" class="form-control" value="{{ $student->birth_date }}">
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
