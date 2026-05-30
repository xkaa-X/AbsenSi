<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tanggal_absen',
        'status', // Hadir, Sakit, Izin, Alpa
        'keterangan',
    ];

    /**
     * Get the siswa that owns the absensi.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
