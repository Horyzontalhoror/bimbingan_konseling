@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Nilai Siswa</h4>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Edit Nilai Siswa</strong>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('nilai.update', $nilai->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Info Siswa -->
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="{{ $nilai->name }}" readonly>
                            <input type="hidden" name="name" value="{{ $nilai->name }}">
                        </div>

                        <div class="form-group">
                            <label>NISN</label>
                            <input type="text" class="form-control" value="{{ $nilai->nisn }}" readonly>
                            <input type="hidden" name="nisn" value="{{ $nilai->nisn }}">
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" class="form-control" value="{{ $nilai->class }}" readonly>
                            <input type="hidden" name="class" value="{{ $nilai->class }}">
                        </div>

                        <!-- Nilai Mapel -->
                        @foreach ([
                            'bindo' => 'B. Indonesia',
                            'bing' => 'B. Inggris',
                            'mat' => 'Matematika',
                            'ipa' => 'IPA',
                            'ips' => 'IPS',
                            'agama' => 'Agama',
                            'ppkn' => 'PPKn',
                            'sosbud' => 'Sosial Budaya',
                            'tik' => 'TIK',
                            'penjas' => 'Penjaskes'
                        ] as $field => $label)
                            <div class="form-group">
                                <label>{{ $label }}</label>
                                <input type="number" step="0.01" name="{{ $field }}" class="form-control" value="{{ $nilai->$field }}" required>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                            </div>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data nilai ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus Nilai</button>
                            </form>
                        </div>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
