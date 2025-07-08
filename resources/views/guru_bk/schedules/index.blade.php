@extends('layouts.app')

@section('title', 'Jadwal Konseling')

@push('styles')
    {{-- Tambahkan style khusus jika diperlukan --}}
    <style>
        .table th,
        .table td {
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-calendar-alt mr-2"></i>Jadwal Konseling</h1>
            <a href="{{ route('schedules.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Buat Jadwal Baru</span>
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Daftar Jadwal Konseling</h6>
                <a href="#collapseFilter" class="btn btn-sm btn-info" data-toggle="collapse" role="button">
                    <i class="fas fa-filter mr-1"></i> Filter Jadwal
                </a>
            </div>

            <!-- Area Filter -->
            <div class="collapse @if(request()->hasAny(['q', 'kelas', 'tanggal', 'status'])) show @endif" id="collapseFilter">
                <div class="card-body bg-light">
                    <form method="GET" action="{{ route('schedules.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="status" class="form-label">Filter Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="Dijadwalkan" {{ request('status') == 'Dijadwalkan' ? 'selected' : '' }}>
                                        Dijadwalkan</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>Batal
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Dari Tanggal:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Sampai Tanggal:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-2 mt-3 mt-md-0">
                                <div class="d-flex">
                                    <button class="btn btn-primary w-100 mr-2" type="submit" title="Terapkan Filter"><i
                                            class="fas fa-check"></i></button>
                                    <a href="{{ route('schedules.index') }}" class="btn btn-secondary w-100"
                                        title="Reset Filter"><i class="fas fa-sync-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Nama Siswa</th>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $index => $schedule)
                                <tr>
                                    <td class="text-center">{{ $schedules->firstItem() + $index }}</td>
                                    <td class="text-left">
                                        <div class="font-weight-bold text-dark">
                                            {{ $schedule->student->name ?? 'Siswa Dihapus' }}</div>
                                        <small class="text-muted">{{ $schedule->student->nisn ?? '-' }} | Kelas:
                                            {{ $schedule->student->class ?? '-' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div>{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('dddd, D MMMM Y') }}
                                        </div>
                                        <small class="text-muted">Pukul
                                            {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</small>
                                    </td>
                                    <td class="text-center">
                                        @if ($schedule->status == 'Dijadwalkan')
                                            <span class="badge badge-warning p-2"><i class="fas fa-clock mr-1"></i>
                                                Dijadwalkan</span>
                                        @elseif($schedule->status == 'Selesai')
                                            <span class="badge badge-success p-2"><i class="fas fa-check-circle mr-1"></i>
                                                Selesai</span>
                                        @elseif($schedule->status == 'Batal')
                                            <span class="badge badge-danger p-2"><i class="fas fa-times-circle mr-1"></i>
                                                Batal</span>
                                        @else
                                            <span class="badge badge-secondary p-2">{{ $schedule->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('schedules.edit', $schedule->id) }}"
                                            class="btn btn-sm btn-warning btn-circle" data-toggle="tooltip"
                                            title="Edit Jadwal">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-circle"
                                                data-toggle="tooltip" title="Hapus Jadwal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-calendar-times fa-3x text-gray-400 mb-3"></i>
                                        <h5 class="font-weight-bold">Belum Ada Jadwal Konseling</h5>
                                        <p class="text-muted">Tidak ada data yang cocok dengan filter Anda. Coba buat
                                            jadwal baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted mb-0 small">
                        Menampilkan <b>{{ $schedules->firstItem() }}</b>-<b>{{ $schedules->lastItem() }}</b> dari
                        <b>{{ $schedules->total() }}</b> jadwal.
                    </p>
                    <div class="d-flex">
                        {{ $schedules->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
