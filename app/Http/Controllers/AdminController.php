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
        $data = Pasien::whereIn('status', ['antri', 'sedang diperiksa'])->get();
        return view('admin.daftarantrian', compact('data'));
    }

    public function rekammedis(){
        $data = Pasien::all()->groupBy(function($patient) {
            return \Carbon\Carbon::parse($patient->tanggal_pemeriksaan)->format('d M Y');
        })->map(function($group) {
            return $group->sortBy('nama_lengkap');
        });
        return view('admin.rekammedis', compact('data'));
    }
    public function deletePatient($id)
    {
        // Find the patient by ID
        $patient = pasien::find($id);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        // Delete the patient
        $patient->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Patient deleted successfully.');
    }
    public function editPatient(Request $request, $id)
    {
        // Find the patient record by ID
        $patient = Pasien::findOrFail($id);

        // Update the patient details with form input
        $patient->nama_lengkap = $request->input('nama');
        $patient->alamat = $request->input('alamat');
        $patient->umur = $request->input('umur');
        $patient->gender = $request->input('gender');
        $patient->pendidikan = $request->input('pendidikan');
        $patient->pekerjaan = $request->input('pekerjaan');
        $patient->tanggal_pemeriksaan = $request->input('tanggal_pemeriksaan');

        // Save the changes to the database
        $patient->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data pasien berhasil diubah.');
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
            $search = $request->input('search');
            $data = Pasien::where('nama_lengkap', 'LIKE', '%' . $search . '%')->get();
        
            // Mengembalikan tampilan parsial untuk daftar pasien
            return view('admin.partials.patient_list', compact('data'))->render();
        }
        public function searchAntrian2(Request $request)
        {
            $search = $request->input('search');
    $data = Pasien::where('nama_lengkap', 'LIKE', '%' . $search . '%')
        ->orderBy('tanggal_pemeriksaan')
        ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d F Y');
        });

    // Render the partial view and return it as a response for AJAX
    return view('admin.partials.patient_list_rm', compact('data'))->render();
        }
    public function markAsCompleted($id)
        {
            $patient = Pasien::findOrFail($id);
            $patient->status = 'selesai';
            $patient->save();
        
            return redirect()->back()->with('success', 'Pasien telah selesai.');
        }
        public function markAsInProgress($id)
        {
            $patient = Pasien::findOrFail($id);
            $patient->status = 'sedang diperiksa';
            $patient->save();
        
            return redirect()->back()->with('success', 'Pasien sedang diperiksa.');
        }
        
        public function updateStatus($id)
        {
            // Temukan pasien berdasarkan ID
            $patient = Pasien::find($id);
        
            if ($patient) {
                // Update status pasien
                $patient->status = 'sedang diperiksa';
                $patient->save();
        
                return response()->json(['success' => true, 'message' => 'Status pasien diperbarui.']);
            }
        
            return response()->json(['success' => false, 'message' => 'Pasien tidak ditemukan.']);
        }

        public function searchSuggestions(Request $request)
            {
                $search = $request->input('search');
                $patients = Pasien::where('nama_lengkap', 'LIKE', "%{$search}%")->limit(5)->get(['nama_lengkap']);
                return response()->json($patients);
            }

}
