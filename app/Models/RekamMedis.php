<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekamMedis extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang dihubungkan dengan model ini.
     *
     * @var string
     */
    protected $table = 'rekam_medis';

    /**
     * Kolom-kolom yang bisa diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'pasien_id',
        'keluhan',
        'diagnosis',
        'obat',
        'tanggal_pemeriksaan',
    ];

    /**
     * Relasi ke tabel `pasiens`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}
