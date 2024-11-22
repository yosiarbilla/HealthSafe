<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $totalPasienHariIni = Antrian::whereDate('created_at', $today)->count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $todayDate = Carbon::now()->format('d M Y');
        $pasienMingguan = Antrian::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->get();

        return view('admin.dashboard', [
            'totalPasienHariIni' => $totalPasienHariIni,
            'pasienMingguan' => $pasienMingguan,
            'todayDate' => $todayDate,
        ]);
    }

    public function patientsToday()
    {
        $today = Carbon::today();
        $patients = Antrian::whereDate('created_at', $today)->with('pasien')->get();
        $totalPatients = $patients->count();

        return view('admin.patients_today', [
            'patients' => $patients,
            'todayDate' => $today->format('d M Y'),
            'totalPatients' => $totalPatients,
        ]);
    }
    public function patientsWeekly()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $patientsByDate = Antrian::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->with('pasien')
            ->get()
            ->groupBy(function ($patient) {
                return Carbon::parse($patient->created_at)->format('d M Y');
            });

        return view('admin.patients_weekly', [
            'patientsByDate' => $patientsByDate,
            'startOfWeek' => $startOfWeek->format('d M Y'),
            'endOfWeek' => $endOfWeek->format('d M Y'),
        ]);
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
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'tanggal_pemeriksaan' => 'required|date',
        ]);

        // Temukan pasien berdasarkan ID
        $patient = Pasien::findOrFail($id);

        // Update data pasien
        $patient->update([
            'nama_lengkap' => $validatedData['nama'],
            'alamat' => $validatedData['alamat'],
            'umur' => $validatedData['umur'],
            'gender' => $validatedData['gender'],
            'pendidikan' => $validatedData['pendidikan'],
            'pekerjaan' => $validatedData['pekerjaan'],
            'tanggal_pemeriksaan' => $validatedData['tanggal_pemeriksaan'],
        ]);
        Log::info('Route editPatient berhasil dipanggil untuk ID: ' . $id);
        Log::info('Redirect ke admin.daftarantrian');

        // Redirect ke halaman daftar antrian dengan pesan sukses
        return redirect()->route('admin.daftarantrian')->with('success', 'Data pasien berhasil diubah.');

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
                ->orderBy('nama_lengkap') // Urutkan berdasarkan nama lengkap
                ->get();

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

        public function detailPasien($id)
        {
            $data = Pasien::with('rekamMedis')->findOrFail($id);

            return view('admin.detail-pasien', compact('data'));
        }


}
