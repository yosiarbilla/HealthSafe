<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function daftarantrian(){
        $data=pasien::all();
        return view('admin.daftarantrian', compact('data'));
    }

    public function rekammedis(){
        $data=pasien::all();
        return view('admin.rekammedis', compact('data'));
    }


    public function tambahantrian(Request $request){
        $data = new pasien;
        $data->nama_lengkap = $request->nama;
        $data->alamat = $request->alamat;
        $data->umur = $request->umur;
        $data->gender = $request->gender;
        $data->pendidikan = $request->pendidikan;
        $data->pekerjaan = $request->pekerjaan;
        $data->tanggal_pemeriksaan = $request->tanggal;
        $data->save();
    
        return redirect()->back()->with('success', 'Pasien berhasil ditambahkan!');
    }


    public function searchAntrian(Request $request)
    {
    $searchQuery = $request->input('search');
    $data = Pasien::where('nama_lengkap', 'LIKE', '%' . $searchQuery . '%')->get();

    $output = '';
    foreach ($data as $index => $patient) {
        $output .= '
            <div class="patient-list" data-bs-toggle="collapse" data-bs-target="#collapsePatient' . $index . '" aria-expanded="false" aria-controls="collapsePatient' . $index . '">
                ' . ($index + 1) . '. ' . $patient->nama_lengkap . '
                <i class="dropdown-icon bi bi-chevron-down collapsed"></i>
            </div>
            <div id="collapsePatient' . $index . '" class="collapse">
                <div class="p-3">
                    <p><strong>Tanggal Pemeriksaan:</strong> ' . \Carbon\Carbon::parse($patient->tanggal_pemeriksaan)->format('d/m/Y') . '</p>
                    <p><strong>Nama:</strong> ' . $patient->nama_lengkap . '</p>
                    <p><strong>Alamat:</strong> ' . $patient->alamat . '</p>
                    <p><strong>Umur:</strong> ' . $patient->umur . '</p>
                    <p><strong>Gender:</strong> ' . $patient->gender . '</p>
                    <p><strong>Pendidikan:</strong> ' . $patient->pendidikan . '</p>
                    <p><strong>Pekerjaan:</strong> ' . $patient->pekerjaan . '</p>
                </div>
            </div>';
    }

    // If no patients are found
    if ($output == '') {
        $output = '<div class="text-center text-muted">No patients found</div>';
    }

    return response($output);
    }

}
