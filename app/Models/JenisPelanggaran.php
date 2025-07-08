<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama', 'poin', 'keterangan',
    ];

    public function violations()
    {
        return $this->hasMany(Violation::class, 'jenis_pelanggaran_id');
    }
}
