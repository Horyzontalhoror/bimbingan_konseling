@extends('layouts.app')

@section('title', 'Surat Panggilan')

@section('content')
<div class="text-center mb-4">
    <h2>Surat Panggilan Orang Tua/Wali</h2>
</div>

<!-- Form untuk menyimpan surat -->
<form method="POST" action="{{ route('call-letter.generate') }}">
    @csrf
    <input type="hidden" name="student_id" value="{{ $student->id }}">
    <input type="hidden" name="class" value="{{ $student->class }}">
    <input type="hidden" name="wali_kelas" value="Wali Kelas Default">
    <input type="hidden" name="tanggal" value="{{ now()->format('Y-m-d') }}">
    <input type="hidden" name="keperluan" value="{{ $reason }}">

    <div class="p-4 border rounded bg-white" style="max-width: 700px; margin: 0 auto;">
        <p>Kepada Yth.</p>
        <p>Orang Tua/Wali dari:</p>
        <table class="table table-borderless w-100">
            <tr>
                <td width="150px">Nama</td>
                <td>: {{ $student->name }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $student->class }}</td>
            </tr>
        </table>

        <p>Dengan hormat,</p>
        <p>Sehubungan dengan {{ $reason }}, kami mengundang Bapak/Ibu untuk hadir ke sekolah guna dilakukan pembicaraan lebih lanjut dengan guru Bimbingan dan Konseling.</p>

        <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>

        <br><br>
        <div class="text-end">
            <p>Hormat kami,</p>
            <br>
            <p>Guru BK</p>
        </div>

        <div class="text-center mt-4 d-flex justify-content-center gap-2">
            <a href="{{ route('call-letter.print', ['student_id' => $student->id]) }}" class="btn btn-danger me-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Unduh Surat
            </a>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Surat
            </button>
        </div>
    </div>
</form>
@endsection
