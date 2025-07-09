@extends('layouts.student')

@section('title', 'Surat Panggilan')

@section('content')
<div class="container-fluid py-4">
    {{-- Page Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-envelope-open-text me-2 text-primary"></i> Surat Panggilan untuk {{ $student->name }}
        </h1>
        {{-- You can add a "Back" button here if needed, or rely on the main navigation --}}
    </div>

    {{-- Student Information Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-graduate me-2"></i> Informasi Siswa
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>NISN:</strong> <span class="text-gray-900">{{ $student->nisn }}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Kelas:</strong> <span class="text-gray-900">{{ $student->class }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Call Letter List Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list me-2"></i> Riwayat Surat Panggilan
            </h6>
        </div>
        <div class="card-body">
            @if ($suratList->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-info-circle me-2"></i> Tidak ada surat panggilan yang tersedia untuk siswa ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle" id="callLettersTable" width="100%" cellspacing="0">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col" class="py-3">No</th>
                                <th scope="col" class="py-3">Tanggal Surat</th>
                                <th scope="col" class="py-3">Keperluan</th>
                                <th scope="col" class="py-3">Waktu Pertemuan</th>
                                <th scope="col" class="py-3">Tempat Pertemuan</th>
                                <th scope="col" class="py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suratList as $index => $surat)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($surat->tanggal)->format('d M Y') }}</td>
                                    <td class="text-left">{{ $surat->keperluan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($surat->waktu_pertemuan)->format('H:i') ?? '-' }} WIB</td>
                                    <td>{{ $surat->tempat_pertemuan ?? '-' }}</td>
                                    <td>
                                        @if ($surat->file)
                                            <a href="{{ asset('storage/surat/' . $surat->file) }}" target="_blank"
                                                class="btn btn-sm btn-primary rounded-pill px-3" data-toggle="tooltip" title="Lihat File Surat">
                                                <i class="fas fa-file-pdf me-1"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted small">- Tidak Ada File -</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            $('#callLettersTable').DataTable({
                responsive: true,
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
                "columnDefs": [
                    { "orderable": false, "targets": [5] } // Disable ordering on 'Aksi' column (index 5)
                ]
            });

            // Initialize tooltip for elements that are present on initial load
            $('[data-toggle="tooltip"]').tooltip();

            // Re-initialize tooltip for elements added by DataTables (e.g., on pagination or search)
            $('#callLettersTable').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });
    </script>
@endpush
