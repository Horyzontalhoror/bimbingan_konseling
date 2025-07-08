@extends('layouts.app')

@section('title', 'Edit Jadwal Konseling')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit mr-2"></i> Edit Jadwal Konseling
            </h1>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Daftar Jadwal
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Jadwal</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Siswa (Disabled) -->
                            <div class="form-group">
                                <label for="student_name" class="font-weight-bold">Nama Siswa</label>
                                <input type="text" id="student_name" class="form-control"
                                    value="{{ $schedule->student->name ?? 'Siswa Dihapus' }} (NISN: {{ $schedule->student->nisn ?? '-' }})"
                                    disabled>
                                <small class="form-text text-muted">Nama siswa tidak dapat diubah pada halaman edit.</small>
                                {{-- Hidden input untuk memastikan student_id tetap ada jika diperlukan di controller --}}
                                <input type="hidden" name="nisn" value="{{ $schedule->nisn }}">
                            </div>

                            <!-- Tanggal & Jam -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date" class="font-weight-bold">Tanggal</label>
                                    <input type="date" id="date" name="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date', $schedule->date) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="time" class="font-weight-bold">Jam</label>
                                    <input type="time" id="time" name="time"
                                        class="form-control @error('time') is-invalid @enderror"
                                        value="{{ old('time', \Carbon\Carbon::parse($schedule->time)->format('H:i')) }}"
                                        required>
                                    @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="form-group">
                                <label for="note" class="font-weight-bold">Catatan / Topik Konseling</label>
                                <textarea id="note" name="note" rows="4" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="Tuliskan topik atau catatan untuk sesi konseling ini...">{{ old('note', $schedule->note) }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status" class="font-weight-bold">Status</label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="Dijadwalkan"
                                        {{ old('status', $schedule->status) == 'Dijadwalkan' ? 'selected' : '' }}>
                                        Dijadwalkan</option>
                                    <option value="Selesai"
                                        {{ old('status', $schedule->status) == 'Selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="Batal"
                                        {{ old('status', $schedule->status) == 'Batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="border-top mt-4 pt-3 d-flex justify-content-end">
                                <a href="{{ route('schedules.index') }}" class="btn btn-secondary mr-2">Batal</a>
                                <button type="submit" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-sync-alt"></i></span>
                                    <span class="text">Perbarui Jadwal</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
