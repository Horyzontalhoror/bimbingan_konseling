@extends('layouts.app')

@section('title', 'Tambah Jadwal Konseling')

@section('content')
<div class="mb-4">
    <h1 class="h4">Tambah Jadwal Konseling</h1>
</div>

<form action="{{ route('schedules.store') }}" method="POST">
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
        <label>Jam</label>
        <input type="time" name="time" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Catatan</label>
        <textarea name="note" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="Terjadwal">Terjadwal</option>
            <option value="Selesai">Selesai</option>
            <option value="Dibatalkan">Dibatalkan</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
