<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    public function examinations() {
        return $this->hasMany(Pasien::class, 'id '); // Replace 'Examination' with the actual model name
    }
    public static function resetQueue()
    {
        $patients = self::where('status', 'antri')
            ->orderBy('updated_at', 'asc')
            ->get();

        foreach ($patients as $index => $patient) {
            $patient->nomor_antrian = $index + 1;
            $patient->save();
        }
    }
}
