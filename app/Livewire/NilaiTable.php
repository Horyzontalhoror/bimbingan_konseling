<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class NilaiTable extends Component
{
    use WithPagination;

    public $q = '';
    public $kelas = '';
    public $kategori = '';

    protected $updatesQueryString = ['q', 'kelas', 'kategori'];

    public function updating($name)
    {
        if (in_array($name, ['q', 'kelas', 'kategori'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $siswa = DB::table('nilai')
            ->select('name', 'class', 'nisn', 'rata_rata', 'kategori')
            ->when($this->kategori, fn($q) => $q->where('kategori', $this->kategori))
            ->when($this->kelas, fn($q) => $q->where('class', $this->kelas))
            ->when($this->q, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'like', "%{$this->q}%")
                          ->orWhere('nisn', 'like', "%{$this->q}%");
                });
            })
            ->orderBy('kategori')
            ->orderByDesc('rata_rata')
            ->paginate(10);

        $semuaKelas = DB::table('nilai')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        return view('livewire.nilai-table', [
            'siswa' => $siswa,
            'semuaKelas' => $semuaKelas
        ]);
    }
}
