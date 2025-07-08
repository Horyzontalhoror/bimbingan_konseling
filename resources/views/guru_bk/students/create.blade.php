@extends('layouts.app')

@section('title', 'Tambah Data Siswa Lengkap')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border: 1px solid #d1d3e2;
            border-radius: .35rem;
        }

        .nav-tabs .nav-link.active {
            background-color: #4e73df;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tambah Data Siswa Lengkap</h1>
        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="siswa-tab" data-toggle="tab" href="#siswa">Data
                        Siswa</a></li>
                <li class="nav-item"><a class="nav-link" id="nilai-tab" data-toggle="tab" href="#nilai">Nilai</a></li>
                <li class="nav-item"><a class="nav-link" id="absensi-tab" data-toggle="tab" href="#absensi">Absensi</a></li>
                <li class="nav-item"><a class="nav-link" id="pelanggaran-tab" data-toggle="tab"
                        href="#pelanggaran">Pelanggaran</a></li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- Tab Data Siswa -->
                <div class="tab-pane fade show active" id="siswa" role="tabpanel">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="class" class="form-control" required>
                    </div>
                </div>

                <!-- Tab Nilai -->
                <div class="tab-pane fade" id="nilai" role="tabpanel">
                    <div class="row">
                        @foreach ([
            'bindo' => 'B. Indonesia',
            'bing' => 'B. Inggris',
            'mat' => 'Matematika',
            'ipa' => 'IPA',
            'ips' => 'IPS',
            'agama' => 'Agama',
            'ppkn' => 'PPKn',
            'sosbud' => 'Sosbud',
            'tik' => 'TIK',
            'penjas' => 'Penjas',
        ] as $key => $label)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ $label }}</label>
                                    <input type="number" name="nilai[{{ $key }}]" class="form-control"
                                        min="0" max="100" value="0" required>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab Absensi -->
                <div class="tab-pane fade" id="absensi" role="tabpanel">
                    <div class="row">
                        @foreach ([
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alpa' => 'Alpa',
            'bolos' => 'Bolos',
        ] as $key => $label)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ $label }}</label>
                                    <input type="number" name="absensi[{{ $key }}]" class="form-control"
                                        min="0" value="0" required>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab Pelanggaran -->
                <div class="tab-pane fade" id="pelanggaran" role="tabpanel">
                    <div id="pelanggaran-wrapper">
                        <div class="pelanggaran-group border rounded p-3 mb-3">
                            <div class="form-group">
                                <label>Jenis Pelanggaran</label>
                                <select name="pelanggaran[][jenis_id]" class="form-control select2">
                                    @foreach ($jenisPelanggaran as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama }} ({{ $jenis->poin }} poin)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="pelanggaran[][tanggal]" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="pelanggaran[][keterangan]" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm remove">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="add-pelanggaran">+ Tambah Pelanggaran</button>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan Semua Data</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
---
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk elemen yang sudah ada
            $('.select2').select2();

            // Fungsi untuk mengupdate indeks name atribut
            function updatePelanggaranIndices() {
                $('#pelanggaran-wrapper .pelanggaran-group').each(function(index) {
                    $(this).find('[name^="pelanggaran"]').each(function() {
                        const originalName = $(this).attr('name');
                        // Ganti 'pelanggaran[]' dengan 'pelanggaran[indeks_baru]'
                        const newName = originalName.replace(/pelanggaran\[\]/,
                            `pelanggaran[${index}]`);
                        $(this).attr('name', newName);
                    });
                });
            }

            // Panggil saat halaman dimuat untuk elemen pertama (jika ada default)
            updatePelanggaranIndices();

            $('#add-pelanggaran').click(function() {
                let clone = $('.pelanggaran-group').first().clone(); // Kloning elemen pertama
                clone.find('input, textarea').val(''); // Kosongkan nilai input
                // Reset select2 pada kloningan
                clone.find('select.select2').val(clone.find('select.select2 option:first').val()).trigger(
                    'change');

                $('#pelanggaran-wrapper').append(clone);
                clone.find('.select2').select2(); // Inisialisasi Select2 untuk kloningan baru
                updatePelanggaranIndices(); // Perbarui semua indeks setelah penambahan
            });

            $(document).on('click', '.remove', function() {
                if ($('.pelanggaran-group').length > 1) {
                    $(this).closest('.pelanggaran-group').remove();
                    updatePelanggaranIndices(); // Perbarui semua indeks setelah penghapusan
                }
            });
        });
    </script>
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('.tab-pane').removeClass('show active');
                $('#siswa-tab').removeClass('active');

                @if ($errors->hasBag('nilai'))
                    $('#nilai').addClass('show active');
                    $('#nilai-tab').addClass('active');
                @elseif ($errors->hasBag('absensi'))
                    $('#absensi').addClass('show active');
                    $('#absensi-tab').addClass('active');
                @elseif ($errors->hasBag('pelanggaran'))
                    $('#pelanggaran').addClass('show active');
                    $('#pelanggaran-tab').addClass('active');
                @else
                    $('#siswa').addClass('show active');
                    $('#siswa-tab').addClass('active');
                @endif
            });
        </script>
    @endif
@endpush
