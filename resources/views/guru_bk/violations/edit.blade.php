@extends('layouts.app')

@section('title', 'Edit Pelanggaran')

@section('content')
<div class="mb-4">
    <h1 class="h4">Edit Data Pelanggaran</h1>
</div>

<form action="{{ route('violations.update', $violation) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Siswa</label>
        <select name="student_id" class="form-control" required>
            @foreach($students as $student)
                <option value="{{ $student->id }}" {{ $student->id == $violation->student_id ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="date" class="form-control" value="{{ $violation->date }}" required>
    </div>
    <div class="mb-3">
        <label>Jenis Pelanggaran</label>
        <input type="text" name="type" class="form-control" value="{{ $violation->type }}" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ $violation->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Tindakan</label>
        <input type="text" name="action" class="form-control" value="{{ $violation->action }}">
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="{{ route('violations.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
