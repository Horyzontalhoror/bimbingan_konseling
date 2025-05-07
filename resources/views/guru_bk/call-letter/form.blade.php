@extends('layouts.app')

@section('title', 'Surat Panggilan')

@section('content')
<div class="mb-4">
    <h1 class="h4">Buat Surat Panggilan Orang Tua</h1>
</div>

<form action="{{ route('call-letter.generate') }}" method="POST" target="_blank">
    @csrf
    <div class="mb-3">
        <label>Nama Siswa</label>
        <select name="student_id" class="form-control" required>
            <option value="">Pilih Siswa</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->class }})</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Alasan Pemanggilan</label>
        <textarea name="reason" class="form-control" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Tampilkan Surat</button>
</form>
@endsection
