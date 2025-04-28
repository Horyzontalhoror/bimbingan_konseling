@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="mb-4">
    <h1 class="h4">Tambah Data Siswa</h1>
</div>

<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>NIS</label>
        <input type="text" name="nis" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kelas</label>
        <input type="text" name="class" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jenis Kelamin</label>
        <select name="gender" class="form-control" required>
            <option value="">Pilih</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="address" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Tanggal Lahir</label>
        <input type="date" name="birth_date" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
