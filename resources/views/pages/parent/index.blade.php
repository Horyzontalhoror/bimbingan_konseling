@extends('layouts.parent')

@section('title', 'Dashboard Orang Tua')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Halaman --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-home me-2 text-primary"></i> Rangkuman Akademik Anak Anda!
            </h1>
            {{-- Tombol atau navigasi tambahan bisa ditambahkan di sini --}}
        </div>

        {{-- Ringkasan Informasi Anak Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-child me-2"></i> Ringkasan Status Anak Anda
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <strong>Nama Anak:</strong> <span class="text-gray-900">{{ $student->name ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>NISN:</strong> <span class="text-gray-900">{{ $student->nisn ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Kelas:</strong> <span class="text-gray-900">{{ $student->class ?? '-' }}</span>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i> Berikut adalah ringkasan status akademik dan informasi penting
                    anak Anda.
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Rata-rata Nilai Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Rata-Rata Nilai Akademik
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $nilai->rata_rata ?? '-' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calculator fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kelas Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Kelas Anak Anda
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $student->class ?? '-' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chalkboard fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tambahkan card lain di sini jika ada data ringkasan lain --}}
            <!-- Contoh: Status Prediksi Akhir -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Keputusan Prediksi Akhir
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $prediksi['Final']->kategori ?? '-' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-brain fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- End of row for summary cards --}}

        {{-- Riwayat Surat Panggilan Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clipboard-list me-2"></i> Riwayat Surat Panggilan
                </h6>
            </div>
            <div class="card-body">
                @if ($surat && count($surat) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle" id="callLettersTable"
                            width="100%" cellspacing="0">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col" class="py-3">No</th>
                                    <th scope="col" class="py-3">Tanggal</th>
                                    <th scope="col" class="py-3">Wali Kelas</th>
                                    <th scope="col" class="py-3">Keperluan</th>
                                    <th scope="col" class="py-3">Waktu Pertemuan</th>
                                    <th scope="col" class="py-3">Tempat Pertemuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surat as $index => $s)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $s->wali_kelas ?? '-' }}</td>
                                        <td class="text-left">{{ $s->keperluan ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($s->waktu_pertemuan)->format('H:i') ?? '-' }} WIB</td>
                                        <td>{{ $s->tempat_pertemuan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-info mb-0"><i class="fas fa-info-circle me-1"></i> Belum ada surat panggilan yang
                            tersedia untuk anak Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
    {{-- Pastikan jQuery sudah dimuat, SB Admin 2 biasanya sudah menyediakan ini --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#jadwalKonselingTable').DataTable({
                responsive: true,
                paging: true, // Enable pagination for the schedule table
                searching: true, // Enable search
                info: true, // Enable info text
                ordering: true, // Enable ordering
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    infoEmpty: "Menampilkan 0 - 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [4, 5]
                    } // Disable ordering for 'Topik/Catatan' and 'Status' columns
                ]
            });
        });
    </script>
@endpush
