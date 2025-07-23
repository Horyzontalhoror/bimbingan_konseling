@extends('layouts.app')

@section('title', 'Detail Surat Panggilan')

@push('styles')
    <style>
        /* Custom style untuk meniru tampilan kertas */
        .surat-container {
            background: white;
            padding: 2.5rem;
            border: 1px solid #e3e6f0;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            line-height: 1.6;
        }

        .kop-surat {
            border-bottom: 4px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .kop-surat img {
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }

        .kop-surat .text-kop {
            text-align: center;
            flex-grow: 1;
        }

        .kop-surat h4,
        .kop-surat h5 {
            margin: 0;
            font-weight: bold;
        }

        .kop-surat p {
            margin: 0;
            font-size: 0.9rem;
        }

        .table-borderless td {
            border: 0 !important;
            padding: 2px 0 !important;
        }

        .signature-block {
            margin-top: 50px;
            width: 250px;
            float: right;
            text-align: left;
        }

        .signature-block .signature-space {
            height: 70px;
        }

        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .surat-container {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4" id="page-header">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-invoice mr-2"></i> Detail Surat Panggilan
            </h1>
            <a href="{{ route('call-letter.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Riwayat
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Pratinjau Dokumen</h6>
                <div>
                    <button onclick="kirimWhatsapp()" class="btn btn-success btn-sm shadow-sm">
                        <i class="fab fa-whatsapp mr-1"></i> Kirim Notifikasi
                    </button>
                    <button onclick="window.print()" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fas fa-print mr-1"></i> Cetak Surat
                    </button>
                </div>
            </div>
            <div class="card-body bg-light" id="print-area">
                <div class="surat-container mx-auto" style="max-width: 30cm;">
                    <!-- KOP SURAT -->
                    <div class="kop-surat">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg"
                            alt="Logo Sekolah">
                        <div class="text-kop">
                            <h5>PEMERINTAH KABUPATEN FLOTIM</h5>
                            <h4>DINAS PENDIDIKAN DAN KEBUDAYAAN</h4>
                            <h4 class="text-primary">SMP NEGERI 1 SOLOR BARAT</h4>
                            <p>Pamakayo, Desa Lewonama, Kecamatan Solor Barat, Kabupaten Flores Timur, NTT
                                <br> Telp: (0341) 123456 | Email: info@smpn1solorbarat.sch.id
                            </p>
                        </div>
                    </div>

                    <!-- NOMOR & TANGGAL SURAT -->
                    <div class="text-right mb-4">
                        Pamakayo, {{ \Carbon\Carbon::parse($surat->tanggal_pertemuan)->isoFormat('D MMMM Y') }}
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td style="width: 25%;">Nomor</td>
                                    <td>: 001/SP/BK/VII/2024</td>
                                </tr>
                                <tr>
                                    <td>Lampiran</td>
                                    <td>: -</td>
                                </tr>
                                <tr>
                                    <td>Perihal</td>
                                    <td>: <strong>Panggilan Orang Tua/Wali Murid</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- TUJUAN SURAT -->
                    <div class="mt-3">
                        <p class="mb-0">Kepada Yth.</p>
                        <p><strong>Bapak/Ibu Orang Tua/Wali dari:</strong></p>
                        <table class="table table-borderless table-sm ml-4" style="width: 80%;">
                            <tr>
                                <td style="width: 25%;">Nama</td>
                                <td>: <strong>{{ $surat->student->name ?? 'N/A' }}</strong></td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $surat->student->class ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>: {{ $surat->student->nisn ?? 'N/A' }}</td>
                            </tr>
                        </table>
                        <p>Di Tempat</p>
                    </div>

                    <!-- ISI SURAT -->
                    <div class="mt-4">
                        <p>Dengan hormat,</p>
                        <p class="text-justify" style="text-indent: 40px;">Sehubungan dengan
                            <strong>{{ $surat->keperluan }}</strong>, maka dengan ini kami mengharap kehadiran Bapak/Ibu
                            Orang Tua/Wali Murid untuk dapat hadir di sekolah pada:
                        </p>
                        <table class="table table-borderless table-sm ml-4" style="width: 80%;">
                            <tr>
                                @php
                                    \Carbon\Carbon::setLocale('id');
                                @endphp
                                <td style="width: 25%;">Hari, Tanggal</td>
                                <td>: {{ \Carbon\Carbon::parse($surat->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td>: {{ \Carbon\Carbon::parse($surat->waktu_pertemuan)->format('H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td>Tempat</td>
                                <td>: {{ $surat->tempat_pertemuan }}</td>
                            </tr>
                        </table>
                        <p class="text-justify" style="text-indent: 40px;">Demikian surat panggilan ini kami sampaikan.
                            Mengingat pentingnya permasalahan ini, kami sangat mengharapkan kehadiran Bapak/Ibu tepat pada
                            waktunya. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.</p>
                    </div>

                    <!-- TANDA TANGAN -->
                    <div class="signature-block">
                        <p class="mb-0">Hormat kami,</p>
                        <p>Guru Bimbingan & Konseling</p>
                        <div class="signature-space"></div>
                        <p class="font-weight-bold mb-0"><u>( Nama Guru BK )</u></p>
                        <p>NIP. ............................</p>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function kirimWhatsapp() {
            const nomorTujuan = '6285342412264'; // Ganti sesuai kebutuhan

            const pesan = `Assalamualaikum Wr. Wb.%0A%0A` +
                `Dengan hormat,%0A` +
                `Kami mengundang Bapak/Ibu Orang Tua/Wali dari siswa:%0A` +
                `*Nama:* {{ urlencode($surat->student->name ?? 'N/A') }}%0A` +
                `*Kelas:* {{ urlencode($surat->student->class ?? 'N/A') }}%0A%0A` +
                `Untuk dapat hadir di sekolah pada:%0A` +
                `*Hari/Tanggal:* {{ urlencode(\Carbon\Carbon::parse($surat->tanggal)->isoFormat('dddd, D MMMM Y')) }}%0A` +
                `*Waktu:* {{ urlencode(\Carbon\Carbon::parse($surat->waktu_pertemuan)->format('H:i')) }} WIB%0A` +
                `*Tempat:* {{ urlencode($surat->tempat_pertemuan) }}%0A%0A` +
                `Keperluan: *{{ urlencode($surat->keperluan) }}*%0A%0A` +
                `Atas perhatian dan kerja samanya kami ucapkan terima kasih.`

            const url = `https://wa.me/${nomorTujuan}?text=${pesan}`;
            window.open(url, '_blank');
        }
    </script>
@endpush
