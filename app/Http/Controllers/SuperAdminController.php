<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\LogRekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
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

        return view('superadmin.dashboard', [
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

        return view('superadmin.patients_today', [
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

        return view('superadmin.patients_weekly', [
            'patientsByWeek' => $formattedPatientsByWeek,
        ]);
    }
    public function users()
    {
        $users = \App\Models\User::paginate(5);

        return view('superadmin.daftaruser', [
            'users' => $users,
        ]);
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('search');

        $users = \App\Models\User::where('name', 'LIKE', "%{$query}%")
        ->orWhere('email', 'LIKE', "%{$query}%")
        ->paginate(5);

        return response()->json([
            'success' => true,
            'users' => $users->items(),
            'pagination' => (string) $users->links('pagination::bootstrap-4'),
        ]);
    }


    public function saveUser(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'sometimes|exists:users,id',
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:dokter,administrasi,superadmin',
            'password' => 'nullable|min:6'
        ]);

        if ($request->has('id')) {
            // Proses update
            $user = User::findOrFail($request->id);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->role = $validatedData['role'];

            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();
        } else {
            // Proses create
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'role' => $validatedData['role'], // Pastikan role disimpan saat create
                'password' => Hash::make($validatedData['password'])
            ]);
        }

        return response()->json(['success' => true]);
    }


    public function deleteUser($id)
    {
        $user = \App\Models\User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan.'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus.']);
    }

    public function logRekamMedis(Request $request)
    {
        $query = LogRekamMedis::with(['dokter', 'rekamMedis.pasien'])->orderBy('created_at', 'desc');

        // Filter berdasarkan nama dokter
        if ($request->doctor_name) {
            $query->whereHas('dokter', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->doctor_name . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate data
        $logs = $query->paginate(10);

        return view('superadmin.log_rekam_medis', compact('logs'));
    }



}
