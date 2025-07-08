@extends('layouts.app')

@section('title', 'Data Nilai Siswa')

@push('styles')
    {{-- Style untuk Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border: 1px solid #d1d3e2;
            border-radius: .35rem;
            width: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #6e707e;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + .75rem);
        }

        /* Style untuk list nilai di modal */
        .nilai-detail-list dt {
            font-weight: 600;
            color: #5a5c69;
        }

        .nilai-detail-list dd {
            font-weight: 700;
            color: #4e73df;
            font-size: 1.1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-chart-bar mr-2"></i>Analisis Nilai Siswa</h1>
            <div>
                <a href="{{ route('nilai.export', request()->query()) }}"
                    class="btn btn-success btn-icon-split btn-sm shadow-sm">
                    <span class="icon text-white-50"><i class="fas fa-file-excel"></i></span>
                    <span class="text">Export ke Excel</span>
                </a>
                <a href="{{ route('nilai.print', request()->query()) }}"
                    class="btn btn-danger btn-icon-split btn-sm shadow-sm">
                    <span class="icon text-white-50"><i class="fas fa-file-pdf"></i></span>
                    <span class="text">Cetak PDF</span>
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Ringkasan Nilai Siswa</h6>
                <a href="#collapseFilterNilai" class="btn btn-sm btn-info" data-toggle="collapse" role="button">
                    <i class="fas fa-filter mr-1"></i> Filter Data
                </a>
            </div>

            <div class="collapse @if (request()->has('q') || request()->has('kelas')) show @endif" id="collapseFilterNilai">
                <div class="card-body bg-light">
                    <form method="GET" action="{{ route('nilai.index') }}">
                        <div class="row align-items-center">
                            <div class="col-md-3 mb-2 mb-md-0">
                                <label for="q" class="form-label small">Cari Nama/NISN</label>
                                <input type="text" name="q" id="q" class="form-control form-control-sm"
                                    placeholder="Ketik untuk mencari..." value="{{ request('q') }}">
                            </div>
                            {{-- <div class="col-md-3 mb-2 mb-md-0">
                                <label for="kategori" class="form-label small">Kategori Nilai</label>
                                <select name="kategori" id="kategori" class="form-control form-control-sm select2-class">
                                    <option value="">Semua Kategori</option>
                                    <option value="Baik" {{ request('kategori') == 'Baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="Cukup" {{ request('kategori') == 'Cukup' ? 'selected' : '' }}>Cukup
                                    </option>
                                    <option value="Butuh Bimbingan"
                                        {{ request('kategori') == 'Butuh Bimbingan' ? 'selected' : '' }}>Butuh Bimbingan
                                    </option>
                                </select>
                            </div> --}}
                            <div class="col-md-3 mb-2 mb-md-0">
                                <label for="kelas" class="form-label small">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control form-control-sm select2-class">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($semuaKelas as $kelas)
                                        <option value="{{ $kelas }}"
                                            {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-none d-md-block">&nbsp;</label>
                                <div class="d-flex">
                                    <button class="btn btn-primary btn-sm w-100 mr-2" type="submit"><i
                                            class="fas fa-check mr-1"></i> Terapkan</button>
                                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary btn-sm w-100"><i
                                            class="fas fa-sync-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Rata-rata</th>
                                {{-- <th class="text-center">Kategori</th> --}}
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $s)
                                <tr>
                                    <td class="text-center align-middle">{{ $loop->iteration + $data->firstItem() - 1 }}
                                    </td>
                                    <td class="align-middle">{{ $s->name }}</td>
                                    <td class="align-middle">{{ $s->nisn }}</td>
                                    <td class="text-center align-middle">{{ $s->class }}</td>
                                    <td class="text-center align-middle font-weight-bold">
                                        {{ number_format($s->rata_rata, 2) }}</td>
                                    {{-- <td class="text-center align-middle">
                                        @if ($s->kategori == 'Baik')
                                            <span class="badge badge-success">Baik</span>
                                        @elseif($s->kategori == 'Cukup')
                                            <span class="badge badge-warning">Cukup</span>
                                        @else
                                            <span class="badge badge-danger">Butuh Bimbingan</span>
                                        @endif
                                    </td> --}}
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-info btn-circle btn-sm" data-toggle="modal"
                                            data-target="#detailNilaiModal" data-nama="{{ $s->name }}"
                                            data-kelas="{{ $s->class }}" data-bindo="{{ $s->bindo }}"
                                            data-bing="{{ $s->bing }}" data-mat="{{ $s->mat }}"
                                            data-ipa="{{ $s->ipa }}" data-ips="{{ $s->ips }}"
                                            data-agama="{{ $s->agama }}" data-ppkn="{{ $s->ppkn }}"
                                            data-sosbud="{{ $s->sosbud }}" data-tik="{{ $s->tik }}"
                                            data-penjas="{{ $s->penjas }}" data-jumlah="{{ $s->jumlah_nilai }}"
                                            data-rata="{{ number_format($s->rata_rata, 2) }}" title="Lihat Detail Nilai">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('nilai.edit', $s->id) }}"
                                            class="btn btn-warning btn-circle btn-sm" title="Edit Nilai"><i
                                                class="fas fa-edit">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                        <h5 class="font-weight-bold">Data Tidak Ditemukan</h5>
                                        <p class="text-muted">Tidak ada data nilai yang sesuai dengan filter Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted mb-0 small">
                        Menampilkan <b>{{ $data->firstItem() }}</b>-<b>{{ $data->lastItem() }}</b> dari
                        <b>{{ $data->total() }}</b> data.
                    </p>
                    <div class="d-flex">
                        {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailNilaiModal" tabindex="-1" role="dialog" aria-labelledby="detailNilaiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-primary" id="detailNilaiModalLabel">Detail Nilai Siswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="modal-nama-siswa" class="font-weight-bold"></h5>
                    <p class="mb-4" id="modal-kelas-siswa"></p>
                    <div class="row nilai-detail-list">
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>B. Indonesia</dt>
                                <dd id="modal-bindo"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>B. Inggris</dt>
                                <dd id="modal-bing"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>Matematika</dt>
                                <dd id="modal-mat"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>Ilmu Pengetahuan Alam (IPA)</dt>
                                <dd id="modal-ipa"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>Ilmu Pengetahuan Sosial (IPS)</dt>
                                <dd id="modal-ips"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>Agama</dt>
                                <dd id="modal-agama"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>PPKn</dt>
                                <dd id="modal-ppkn"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>Seni Budaya</dt>
                                <dd id="modal-sosbud"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>TIK</dt>
                                <dd id="modal-tik"></dd>
                            </dl>
                        </div>
                        <div class="col-md-4 mb-3">
                            <dl>
                                <dt>Penjas</dt>
                                <dd id="modal-penjas"></dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-6 text-center">
                            <h6 class="text-muted">JUMLAH NILAI</h6>
                            <h4 class="font-weight-bold" id="modal-jumlah"></h4>
                        </div>
                        <div class="col-6 text-center">
                            <h6 class="text-muted">RATA-RATA</h6>
                            <h4 class="font-weight-bold" id="modal-rata"></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk Select2 dan Modal --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-class').select2({
                width: '100%'
            });

            // Script untuk mengisi data ke modal saat akan ditampilkan
            $('#detailNilaiModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var modal = $(this);

                // Ekstrak data dari atribut data-*
                modal.find('#modal-nama-siswa').text(button.data('nama'));
                modal.find('#modal-kelas-siswa').text('Kelas: ' + button.data('kelas'));
                modal.find('#modal-bindo').text(button.data('bindo'));
                modal.find('#modal-bing').text(button.data('bing'));
                modal.find('#modal-mat').text(button.data('mat'));
                modal.find('#modal-ipa').text(button.data('ipa'));
                modal.find('#modal-ips').text(button.data('ips'));
                modal.find('#modal-agama').text(button.data('agama'));
                modal.find('#modal-ppkn').text(button.data('ppkn'));
                modal.find('#modal-sosbud').text(button.data('sosbud'));
                modal.find('#modal-tik').text(button.data('tik'));
                modal.find('#modal-penjas').text(button.data('penjas'));
                modal.find('#modal-jumlah').text(button.data('jumlah'));
                modal.find('#modal-rata').text(button.data('rata'));
            });
        });
    </script>
@endpush
