<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\LogRekamMedis;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $totalPasienHariIni = Antrian::whereDate('created_at', $today)->count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $todayDate = Carbon::now()->format('d M Y');
        $pasienMingguan = Antrian::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->get();

        return view('dokter.dashboard', [
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

        return view('dokter.patients_today', [
            'patients' => $patients,
            'todayDate' => $today->format('d M Y'),
            'totalPatients' => $totalPatients,
        ]);
    }
    public function patientsWeekly()
    {
        // Ambil semua data antrian, tidak terbatas minggu ini saja
        $patientsByWeek = Antrian::with('pasien')
            ->get()
            ->groupBy(function ($patient) {
                // Kelompokkan berdasarkan minggu (tahun + minggu ke berapa)
                $date = Carbon::parse($patient->created_at);
                return $date->year . ' - Week ' . $date->week;
            });

        // Format minggu agar lebih mudah dibaca di view
        $formattedPatientsByWeek = $patientsByWeek->mapWithKeys(function ($patients, $week) {
            $firstDate = Carbon::parse($patients->first()->created_at)->startOfWeek()->format('d M Y');
            $lastDate = Carbon::parse($patients->first()->created_at)->endOfWeek()->format('d M Y');
            return ["$firstDate - $lastDate" => $patients];
        });

        return view('dokter.patients_weekly', [
            'patientsByWeek' => $formattedPatientsByWeek,
        ]);
    }
    public function daftarantrian(){
        $data = Antrian::with('pasien')
        ->whereIn('status', ['antri', 'sedang diperiksa'])
        ->orderBy('nomor_antrian', 'asc')
        ->get();

        return view('dokter.daftarantrian', compact('data'));
    }
    public function rekammedis(){
        $data = Pasien::paginate(10);
        return view('dokter.rekammedis', compact('data'));
    }

    public function lihatdetail($id) {
        $data = Pasien::with('rekamMedis')->findOrFail($id);
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

        $this->resetQueue();

        return redirect()->back()->with('success', 'Pasien telah selesai.');
    }

    public function markAsInProgress($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update(['status' => 'sedang diperiksa']);

            // Redirect to Rekam Medis page with patient data
        return redirect()->back()->with('success', 'Pasien sedang diperiksa.');
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
        // Validasi input
        $request->validate([
            'id' => 'required|exists:antrian,id',
            'keluhan' => 'required|string',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
        ]);

        $antrian = Antrian::findOrFail($request->id);

        RekamMedis::create([
            'pasien_id' => $antrian->pasien_id,
            'keluhan' => $request->input('keluhan'),
            'diagnosis' => $request->input('diagnosis'),
            'obat' => $request->input('obat'),
            'tindakan' => $request->input('tindakan'),
            'tanggal_pemeriksaan' => now(),
        ]);

        $antrian->update(['status' => 'selesai']);
        $antrian->save();

        return response()->json([
            'success' => true,
            'message' => 'Data pemeriksaan berhasil disimpan.',
        ]);
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

    public function edit($id)
    {
        $record = RekamMedis::findOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'keluhan' => 'required|string',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'obat' => 'required|string',
        ]);

        $record = RekamMedis::findOrFail($id);

        $originalData = $record->only(['keluhan', 'diagnosis', 'tindakan', 'obat']);
        $changes = array_diff($validatedData, $originalData);

        $record->update($validatedData);

        LogRekamMedis::create([
            'dokter_id' => Auth::id(),
            'rekam_medis_id' => $record->id,
            'action' => 'update',
            'changes' => json_encode([
                'keluhan' => ['old' => $originalData['keluhan'], 'new' => $validatedData['keluhan']],
                'diagnosis' => ['old' => $originalData['diagnosis'], 'new' => $validatedData['diagnosis']],
                'tindakan' => ['old' => $originalData['tindakan'], 'new' => $validatedData['tindakan']],
                'obat' => ['old' => $originalData['obat'], 'new' => $validatedData['obat']],
            ]),
            'created_at' => now(),
        ]);


        return redirect()->back()->with('success', 'Rekam medis berhasil diperbarui');
    }


}
