<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
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
        $data = Pasien::all();
        return view('dokter.rekammedis', compact('data'));
    }

    public function lihatdetail($id) {
        $data = Pasien::with('examinations')->find($id); // Make sure 'examinations' is the correct relationship name
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

// In DokterController.php
    public function markAsCompleted($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->status = 'selesai';
        $antrian->save();

        return redirect()->back()->with('success', 'Pasien telah selesai.');
    }
    public function markAsInProgress($id)
    {
        $antrian = Antrian::findOrFail($id);

            // Update the status to 'sedang diperiksa'
        $antrian->status = 'sedang diperiksa';
        $antrian->save();

            // Redirect to Rekam Medis page with patient data
        return redirect()->route('dokter.rekammedis', ['id' => $id])->with('patient', $antrian);
    }

    public function updateStatus($id)
    {
            // Temukan pasien berdasarkan ID
        $antrian = Antrian::find($id);

        if ($antrian) {
            // Update status pasien
            $antrian->status = 'sedang diperiksa';
            $antrian->save();

            return response()->json(['success' => true, 'message' => 'Status pasien diperbarui.']);
        }

        return response()->json(['success' => false, 'message' => 'Pasien tidak ditemukan.']);
    }
    public function saveExamination(Request $request)
    {
        $patient = Pasien::find($request->id); // Sesuaikan dengan ID yang dikirim dari form
        if ($patient) {
            $patient->keluhan = $request->keluhan;
            $patient->diagnosis = $request->diagnosis;
            $patient->obat = $request->obat;
            $patient->status = 'selesai'; // Ubah status pasien menjadi 'selesai'
            $patient->save();

            return response()->json(['success' => true, 'message' => 'Examination data saved successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Patient not found']);
    }
    public function deletePatient($id)
    {
        $patient = Pasien::find($id);
        if ($patient) {
            $patient->delete();
            return response()->json(['success' => true, 'message' => 'Data pasien berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => 'Data pasien tidak ditemukan.']);
    }


}
