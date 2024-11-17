<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    public function examinations() {
        return $this->hasMany(Pasien::class, 'id '); // Replace 'Examination' with the actual model name
    }
}
