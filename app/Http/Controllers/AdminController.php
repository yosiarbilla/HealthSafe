<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function daftarantrian()
    {
        $data = Antrian::with('pasien') // Memuat relasi pasien
        ->whereIn('status', ['antri', 'sedang diperiksa']) // Ambil antrean dengan status "antri" dan "sedang diperiksa"
        ->orderBy('nomor_antrian', 'asc') // Urutkan berdasarkan nomor antrian
        ->get();

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
        $patient = Pasien::findOrFail($id);

        $patient->nama_lengkap = $request->input('nama');
        $patient->alamat = $request->input('alamat');
        $patient->umur = $request->input('umur');
        $patient->gender = $request->input('gender');
        $patient->pendidikan = $request->input('pendidikan');
        $patient->pekerjaan = $request->input('pekerjaan');
        $patient->tanggal_pemeriksaan = $request->input('tanggal_pemeriksaan');

        $patient->save();

        return redirect()->back()->with('success', 'Data pasien berhasil diubah.');
    }
    public function tambahantrian(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pasiens,id',
        ]);

        $existingQueue = Antrian::where('pasien_id', $request->id)->where('status', 'antri')->first();
        if ($existingQueue) {
            return response()->json(['success' => false, 'message' => 'Pasien sudah ada di antrean.']);
        }

        $nomor_antrian = Antrian::where('status', 'antri')->max('nomor_antrian') + 1;

        $antrian = new Antrian();
        $antrian->pasien_id = $request->id;
        $antrian->nomor_antrian = $nomor_antrian;
        $antrian->status = 'antri';
        $antrian->save();

        return response()->json(['success' => true, 'message' => 'Pasien berhasil ditambahkan ke antrean.']);
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
    protected function resetQueue()
    {
        $antrianAktif = Antrian::where('status', 'antri')->orderBy('nomor_antrian', 'asc')->get();

        foreach ($antrianAktif as $index => $antrian) {
            $antrian->nomor_antrian = $index + 1;
            $antrian->save();
        }
    }
    public function markAsCompleted($id)
        {
            $antrian = Antrian::findOrFail($id);
            $antrian->status = 'selesai';
            $antrian->nomor_antrian = null;
            $antrian->save();

            // Reset antrean lainnya
            $this->resetQueue();

            return redirect()->back()->with('success', 'Pasien telah selesai.');
        }
        public function markAsInProgress($id)
        {
            $antrian = Antrian::findOrFail($id);
            $antrian->status = 'sedang diperiksa';
            $antrian->save();


            return redirect()->back()->with('success', 'Pasien sedang diperiksa.');
        }

        public function updateStatus($id)
        {
            // Temukan pasien berdasarkan ID
            $antrian = Pasien::find($id);

            if ($antrian) {
                // Update status pasien
                $antrian->status = 'sedang diperiksa';
                $antrian->save();

                return response()->json(['success' => true, 'message' => 'Status pasien diperbarui.']);
            }

            return response()->json(['success' => false, 'message' => 'Pasien tidak ditemukan.']);
        }

        public function searchSuggestions(Request $request)
        {
            $search = $request->input('search');
            $patients = Pasien::where('nama_lengkap', 'LIKE', "%{$search}%")
                ->limit(5)
                ->get(['id', 'nama_lengkap']); // Pastikan 'id' dan 'nama_lengkap' dipilih

            Log::info($patients); // Debug log pasien yang ditemukan
            return response()->json($patients);
        }
        public function tambahpasien(Request $request){
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


}
