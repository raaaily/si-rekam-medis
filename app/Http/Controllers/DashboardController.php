<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Assessment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // KARTU STATISTIK
        // =====================
        $totalPasien = Patient::count();

        $pasienHariIni = Patient::whereDate('created_at', today())->count();

        $rekamMedisHariIni = Assessment::whereDate('created_at', today())->count();

        // SESUAI ROLE KAMU → doctor
        $dokterAktif = User::where('role', 'doctor')->count();

        // =====================
        // PASIEN TERBARU
        // =====================
        $latestPatients = Patient::latest()->take(5)->get();

        // =====================
        // GRAFIK 12 BULAN TERAKHIR
        // =====================
        $assessments = Assessment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // isi default 12 bulan = 0
        $assessmentCounts = array_fill(1, 12, 0);

        foreach ($assessments as $item) {
            $assessmentCounts[$item->month] = $item->total;
        }

        $assessmentMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $assessmentMonths[] = Carbon::create()->month($i)->translatedFormat('M');
        }

        // reset index array
        $assessmentCounts = array_values($assessmentCounts);

        return view('dashboard', compact(
            'totalPasien',
            'pasienHariIni',
            'rekamMedisHariIni',
            'dokterAktif',
            'latestPatients',
            'assessmentMonths',
            'assessmentCounts'
        ));
    }
}
