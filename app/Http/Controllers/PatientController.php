<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(15);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        // Buat nomor RM otomatis
        $lastPatient = Patient::orderBy('id', 'desc')->first();
        $newNumber = 1;

        if ($lastPatient && preg_match('/^RM(\d+)-/', $lastPatient->no_rm, $matches)) {
            $newNumber = intval($matches[1]) + 1;
        }

        $newRm = 'RM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd');
        return view('patients.create', compact('newRm'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => 'required|numeric|unique:patients,nik',
            'no_asuransi' => 'nullable|string|max:50',
            'nama_lengkap' => 'required|string|max:255',
            'kepala_keluarga' => 'nullable|string|max:255',
            'no_kk' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'provinsi' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'dusun' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'hubungan_dalam_keluarga' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        // Generate nomor RM otomatis
        $lastPatient = Patient::orderBy('id', 'desc')->first();
        $newNumber = 1;

        if ($lastPatient && preg_match('/^RM(\d+)-/', $lastPatient->no_rm, $matches)) {
            $newNumber = intval($matches[1]) + 1;
        }

        $data['no_rm'] = 'RM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd');

        Patient::create($data);

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'nik' => 'required|numeric|unique:patients,nik,' . $patient->id,
            'no_asuransi' => 'nullable|string|max:50',
            'nama_lengkap' => 'required|string|max:255',
            'kepala_keluarga' => 'nullable|string|max:255',
            'no_kk' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'provinsi' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'dusun' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'hubungan_dalam_keluarga' => 'nullable|string|max:50',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
        ]);

        $patient->update($data);

        return redirect()->route('patients.show', $patient->id)->with('success', 'Data pasien diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Data pasien dihapus.');
    }
}
