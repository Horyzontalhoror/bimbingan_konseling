@extends('layouts.app')

@section('title', 'Surat Panggilan')

@section('content')
<div class="text-center mb-4">
    <h2>Surat Panggilan Orang Tua/Wali</h2>
</div>

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
        <p>Guru BK</p>
    </div>
</div>
@endsection
