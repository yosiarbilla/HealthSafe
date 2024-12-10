<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id',
        'rekam_medis_id',
        'action',
        'changes',
        'created_at',
    ];

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'rekam_medis_id');
    }
}
