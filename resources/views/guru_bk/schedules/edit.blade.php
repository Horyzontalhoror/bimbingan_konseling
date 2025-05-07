@extends('layouts.app')

@section('title', 'Edit Jadwal Konseling')

@section('content')
<div class="mb-4">
    <h1 class="h4">Edit Jadwal Konseling</h1>
</div>

<form action="{{ route('schedules.update', $schedule) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Siswa</label>
        <select name="student_id" class="form-control" required>
            @foreach($students as $student)
                <option value="{{ $student->id }}" {{ $student->id == $schedule->student_id ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="date" class="form-control" value="{{ $schedule->date }}" required>
    </div>
    <div class="mb-3">
        <label>Jam</label>
        <input type="time" name="time" class="form-control" value="{{ $schedule->time }}" required>
    </div>
    <div class="mb-3">
        <label>Catatan</label>
        <textarea name="note" class="form-control">{{ $schedule->note }}</textarea>
    </div>
    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="Terjadwal" {{ $schedule->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
            <option value="Selesai" {{ $schedule->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Dibatalkan" {{ $schedule->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Perbarui</button>
    <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
