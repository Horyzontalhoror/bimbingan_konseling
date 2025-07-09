<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';

    protected $fillable = [
        'nisn',
        'tanggal',
        'waktu',
        'tempat',
        'topik',
        'catatan',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }
}
