<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Violation;
use App\Models\nilai;
use App\Models\RekomendasiSiswa;
use App\Models\CounselingSchedule;


class Student extends Model
{
    protected $table = 'students';

    protected $fillable = ['nisn', 'name', 'class'];

    public function violations()
    {
        return $this->hasMany(Violation::class, 'nisn', 'nisn');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'nisn', 'nisn');
    }

    public function rekomendasi()
    {
        return $this->hasOne(RekomendasiSiswa::class, 'nisn', 'nisn');
    }

    public function jadwalKonseling()
    {
        return $this->hasMany(CounselingSchedule::class, 'nisn', 'nisn');
    }
}
