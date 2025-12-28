<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AssessmentController extends Controller
{
    /**
     * Daftar semua pasien
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
        }

        $patients = $query->orderBy('nama_lengkap')->paginate(10);

        return view('assessments.index', compact('patients'));
    }

    /**
     * Riwayat assessment satu pasien
     */
    public function history($patient_id)
    {
        $patient = Patient::with(['assessments' => function ($q) {
            $q->with('petugas')->orderByDesc('created_at');
        }])->findOrFail($patient_id);

        Session::put('selected_patient_id', $patient_id);

        return view('assessments.history', compact('patient'));
    }

    /**
     * Form tambah assessment
     */
    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);

        $prognosaOptions = ['Baik (dubia ad bonam)', 'Sedang', 'Buruk (dubia ad malam)'];
        $kesadaranOptions = ['Compos mentis', 'Apatis', 'Somnolen', 'Sopor', 'Koma'];

        // $diagnosesOptions = [
        //     (object)['name' => 'Demam'],
        //     (object)['name' => 'Flu'],
        //     (object)['name' => 'Asma'],
        //     (object)['name' => 'Diabetes']
        // ];

        $proceduresOptions = [
            (object)['name' => 'Suntik'],
            (object)['name' => 'Infus'],
            (object)['name' => 'Laboratorium']
        ];

        // $medicationsOptions = [
        //     (object)['name' => 'Paracetamol'],
        //     (object)['name' => 'Amoxicillin'],
        //     (object)['name' => 'Vitamin C']
        // ];

        return view('assessments.create', compact(
            'patient',
            'prognosaOptions',
            'kesadaranOptions',
            // 'diagnosesOptions',
            'proceduresOptions',
            // 'medicationsOptions'
        ));
    }

    /**
     * Simpan assessment baru
     */
    public function store(Request $request)
    {
        // 🔥 NORMALISASI INPUT SEBELUM VALIDASI
        if ($request->filled('lila')) {
            $request->merge([
                'lila' => str_replace(',', '.', $request->lila)
            ]);
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'kunjungan_ke' => 'nullable|integer',
            'keluhan' => 'nullable|string',
            'anamnesa' => 'nullable|string',
            'terapi_non_obat' => 'nullable|string',
            'prognosa' => 'nullable|string',
            'kesadaran' => 'nullable|string',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'imt' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            'lingkar_perut' => 'nullable|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'tekanan_sistolik' => 'nullable|numeric',
            'tekanan_diastolik' => 'nullable|numeric',
            'rr' => 'nullable|numeric',
            'hr' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'gds' => 'nullable|numeric',
            'alergi_makanan' => 'nullable|string',
            'alergi_udara' => 'nullable|string',
            'alergi_obat' => 'nullable|string',
            'soap_subjektif' => 'nullable|string',
            'soap_objektif' => 'nullable|string',
            'soap_assesmen' => 'nullable|string',
            'soap_perencanaan' => 'nullable|string',
            'kategori_kunjungan' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'catatan' => 'nullable|string',

            'diagnoses.*.diagnosa' => 'required|string',
            'diagnoses.*.kategori' => 'nullable|string',

            'procedures.*.tindakan' => 'required|string',
            'procedures.*.jumlah' => 'nullable|integer',
            'procedures.*.pembayaran' => 'nullable|string',
            'procedures.*.harga' => 'nullable',

            'medications.*.nama_obat' => 'required|string',
            'medications.*.jenis' => 'nullable|string',
            'medications.*.dosis' => 'nullable|string',
            'medications.*.jumlah' => 'nullable|integer',
        ]);

        $validated['petugas_id'] = Auth::id();

        // Simpan assessment utama
        $assessment = Assessment::create(
            collect($validated)->except(['diagnoses', 'procedures', 'medications'])->toArray()
        );

        // Diagnoses
        foreach ($validated['diagnoses'] ?? [] as $diag) {
            $assessment->diagnoses()->create($diag);
        }

        // Procedures
        foreach ($validated['procedures'] ?? [] as $proc) {
            if (!empty($proc['harga'])) {
                $proc['harga'] = str_replace('.', '', $proc['harga']);
            }
            $assessment->procedures()->create($proc);
        }

        // Medications
        foreach ($validated['medications'] ?? [] as $med) {
            $assessment->medications()->create($med);
        }

        return redirect()
            ->route('assessments.history', $validated['patient_id'])
            ->with('success', 'Assessment berhasil disimpan.');
    }

    /**
     * Detail assessment
     */
    public function show(Assessment $assessment)
    {
        $assessment->load(['patient', 'petugas', 'diagnoses', 'procedures', 'medications']);
        return view('assessments.show', compact('assessment'));
    }

    /**
     * Form edit assessment
     */
    public function edit(Assessment $assessment)
    {
        $assessment->load(['patient', 'diagnoses', 'procedures', 'medications']);

        $prognosaOptions = ['Baik (dubia ad bonam)', 'Sedang', 'Buruk (dubia ad malam)'];
        $kesadaranOptions = ['Compos mentis', 'Apatis', 'Somnolen', 'Sopor', 'Koma'];

        return view('assessments.edit', compact(
            'assessment',
            'prognosaOptions',
            'kesadaranOptions'
        ));
    }

    /**
     * Update assessment
     */
    public function update(Request $request, Assessment $assessment)
    {
        if ($request->filled('lila')) {
            $request->merge([
                'lila' => str_replace(',', '.', $request->lila)
            ]);
        }

        $validated = $request->validate([
            'kunjungan_ke' => 'nullable|integer',
            'keluhan' => 'nullable|string',
            'anamnesa' => 'nullable|string',
            'terapi_non_obat' => 'nullable|string',
            'prognosa' => 'nullable|string',
            'kesadaran' => 'nullable|string',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'imt' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            'lingkar_perut' => 'nullable|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'tekanan_sistolik' => 'nullable|numeric',
            'tekanan_diastolik' => 'nullable|numeric',
            'rr' => 'nullable|numeric',
            'hr' => 'nullable|numeric',
            'suhu' => 'nullable|numeric',
            'gds' => 'nullable|numeric',
            'alergi_makanan' => 'nullable|string',
            'alergi_udara' => 'nullable|string',
            'alergi_obat' => 'nullable|string',
            'soap_subjektif' => 'nullable|string',
            'soap_objektif' => 'nullable|string',
            'soap_assesmen' => 'nullable|string',
            'soap_perencanaan' => 'nullable|string',
            'kategori_kunjungan' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'catatan' => 'nullable|string',

            'diagnoses.*.diagnosa' => 'required|string',
            'diagnoses.*.kategori' => 'nullable|string',

            'procedures.*.tindakan' => 'required|string',
            'procedures.*.jumlah' => 'nullable|integer',
            'procedures.*.pembayaran' => 'nullable|string',
            'procedures.*.harga' => 'nullable',

            'medications.*.nama_obat' => 'required|string',
            'medications.*.jenis' => 'nullable|string',
            'medications.*.dosis' => 'nullable|string',
            'medications.*.jumlah' => 'nullable|integer',
        ]);

        $assessment->update(
            collect($validated)->except(['diagnoses', 'procedures', 'medications'])->toArray()
        );

        $assessment->diagnoses()->delete();
        $assessment->procedures()->delete();
        $assessment->medications()->delete();

        foreach ($validated['diagnoses'] ?? [] as $diag) {
            $assessment->diagnoses()->create($diag);
        }

        foreach ($validated['procedures'] ?? [] as $proc) {
            if (!empty($proc['harga'])) {
                $proc['harga'] = str_replace('.', '', $proc['harga']);
            }
            $assessment->procedures()->create($proc);
        }

        foreach ($validated['medications'] ?? [] as $med) {
            $assessment->medications()->create($med);
        }

        return redirect()
            ->route('assessments.history', $assessment->patient_id)
            ->with('success', 'Assessment berhasil diperbarui.');
    }

    /**
     * Hapus assessment
     */
    public function destroy(Assessment $assessment)
    {
        $patientId = $assessment->patient_id;

        $assessment->diagnoses()->delete();
        $assessment->procedures()->delete();
        $assessment->medications()->delete();
        $assessment->delete();

        return redirect()
            ->route('assessments.history', $patientId)
            ->with('success', 'Assessment berhasil dihapus.');
    }
}
