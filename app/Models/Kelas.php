<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
    ];

    /**
     * Get the jurusan that owns the kelas.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Get the siswas for the kelas.
     */
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
