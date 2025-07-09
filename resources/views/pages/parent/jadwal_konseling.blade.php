@extends('layouts.parent')

@section('title', 'Jadwal Konseling Anak')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Halaman --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-alt me-2 text-primary"></i> Jadwal Konseling Anak Anda
            </h1>
            {{-- Tombol atau navigasi tambahan bisa ditambahkan di sini --}}
        </div>

        {{-- Informasi Anak Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-child me-2"></i> Informasi Anak
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Nama:</strong> <span class="text-gray-900">{{ $student->name ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>NISN:</strong> <span class="text-gray-900">{{ $student->nisn ?? '-' }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kelas:</strong> <span class="text-gray-900">{{ $student->class ?? '-' }}</span>
                    </div>
                </div>
                <p class="text-muted mt-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i> Berikut adalah daftar jadwal konseling yang telah ditetapkan
                    untuk anak Anda.
                </p>
            </div>
        </div>

        {{-- Jadwal Konseling List Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-check me-2"></i> Daftar Jadwal Konseling
                </h6>
            </div>
            <div class="card-body">
                @if ($jadwal && count($jadwal) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle"
                            id="counselingScheduleTable" width="100%" cellspacing="0">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col" class="py-3">No</th>
                                    <th scope="col" class="py-3">Tanggal</th>
                                    <th scope="col" class="py-3">Waktu</th>
                                    <th scope="col" class="py-3">Tempat</th>
                                    <th scope="col" class="py-3">Catatan</th>
                                    <th scope="col" class="py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal as $index => $item)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                                        <td>{{ $item->time ?? '-' }}</td>
                                        <td>{{ $item->tempat_pertemuan ?? '-' }}</td>
                                        <td class="text-left">{{ $item->note ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge badge-pill px-3 py-2
                                            @if ($item->status === 'terjadwal') badge-info
                                            @elseif ($item->status === 'selesai') badge-success
                                            @elseif ($item->status === 'batal') badge-danger
                                            @else badge-secondary @endif">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-info mb-0"><i class="fas fa-info-circle me-1"></i> Belum ada jadwal konseling yang
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
            $('#counselingScheduleTable').DataTable({
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
                "columnDefs": [{
                        "orderable": false,
                        "targets": '_all'
                    } // Menonaktifkan pengurutan untuk semua kolom
                ]
            });
        });
    </script>
@endpush
