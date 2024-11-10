<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index(){
        return view('dokter.dashboard');
    }
    public function daftarantrian(){
        $data=pasien::all();
        return view('dokter.daftarantrian', compact('data'));
    }
    public function rekammedis(){
        $data=pasien::all();
        return view('dokter.rekammedis', compact('data'));
    }

    public function lihatdetail($id) {
        $data = Pasien::findOrFail($id); // Retrieve the patient data based on the ID
        return view('dokter.lihatdetail', compact('data'));
    }
    

    public function searchAntrian(Request $request)
{
    $searchQuery = $request->input('search');
    $data = Pasien::where('nama_lengkap', 'LIKE', '%' . $searchQuery . '%')->get();

    $output = '';
    foreach ($data as $index => $patient) {
        $output .= '
            <div class="patient-list d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#collapsePatient' . $index . '" aria-expanded="false" aria-controls="collapsePatient' . $index . '">
                <span>' . ($index + 1) . '. ' . $patient->nama_lengkap . '</span>
            </div>';
    }

    if ($output == '') {
        $output = '<div class="text-center text-muted">No patients found</div>';
    }

    return response($output);
}
}
