@extends('layouts.parent')

@section('title', 'Nilai Anak')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Halaman --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-graduation-cap me-2 text-primary"></i> Nilai Anak Anda
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
                    <i class="fas fa-info-circle me-1"></i> Berikut adalah detail nilai akademik dari anak Anda.
                </p>
            </div>
        </div>

        {{-- Data Nilai Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book-open me-2"></i> Rincian Nilai Mata Pelajaran
                </h6>
            </div>
            <div class="card-body">
                @if ($nilai)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle" id="gradesTable"
                            width="100%" cellspacing="0">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col" class="py-3">Mata Pelajaran</th>
                                    <th scope="col" class="py-3">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left font-weight-bold">Bahasa Indonesia</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->bindo ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">Bahasa Inggris</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->bing ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">Matematika</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->mat ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">IPA</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->ipa ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">IPS</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->ips ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">Agama</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->agama ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">PPKn</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->ppkn ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">Sosial Budaya</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->sosbud ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">TIK</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->tik ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-left font-weight-bold">Penjas</td>
                                    <td class="text-center"><span
                                            class="badge badge-primary px-3 py-2">{{ $nilai->penjas ?? '-' }}</span></td>
                                </tr>
                                <tr class="table-info font-weight-bold">
                                    <td class="text-left">Rata-Rata</td>
                                    <td class="text-center"><span
                                            class="badge badge-info px-3 py-2">{{ $nilai->rata_rata ?? '-' }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Nilai anak Anda belum
                            tersedia.</p>
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
            $('#gradesTable').DataTable({
                responsive: true,
                paging: false, // Disable pagination as it's a single row of data
                searching: false, // Disable search
                info: false, // Disable "Showing X of Y entries" info
                ordering: false, // Disable ordering for all columns
                language: {
                    zeroRecords: "Tidak ditemukan data yang cocok"
                }
            });
        });
    </script>
@endpush
