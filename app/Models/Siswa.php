<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama',
        'alamat',
        'jenis_kelamin',
        'kelas_id',
    ];

    /**
     * Get the kelas that owns the siswa.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the absensis for the siswa.
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }
}
