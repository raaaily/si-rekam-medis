@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detail Pasien</h1>
        <div>
            <a href="{{ route('patients.edit', $patient) }}" class="bg-yellow-400 text-white px-3 py-2 rounded">Edit</a>
            <a href="{{ route('patients.index') }}" class="bg-gray-400 text-white px-3 py-2 rounded">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p><strong>No RM:</strong> {{ $patient->no_rm }}</p>
            <p><strong>NIK:</strong> {{ $patient->nik }}</p>
            <p><strong>Nama Lengkap:</strong> {{ $patient->nama_lengkap }}</p>
            <p><strong>Kepala Keluarga:</strong> {{ $patient->kepala_keluarga }}</p>
            <p><strong>No KK:</strong> {{ $patient->no_kk }}</p>
            <p>
                <strong>Tempat / Tgl Lahir:</strong>
                {{ $patient->tempat_lahir }} / {{ $patient->tanggal_lahir }}
            </p>
            <p><strong>Umur:</strong> {{ $patient->umur ? $patient->umur . ' tahun' : '-' }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $patient->jenis_kelamin }}</p>
            <p><strong>Telepon:</strong> {{ $patient->telepon }}</p>
        </div>

        <div>
            <p><strong>Alamat:</strong> {{ $patient->alamat }}</p>
            <p><strong>RT / RW:</strong> {{ $patient->rt }} / {{ $patient->rw }}</p>
            <p><strong>Provinsi:</strong> {{ $patient->provinsi }}</p>
            <p><strong>Kabupaten:</strong> {{ $patient->kabupaten }}</p>
            <p><strong>Kecamatan:</strong> {{ $patient->kecamatan }}</p>
            <p><strong>Desa / Dusun:</strong> {{ $patient->desa }} / {{ $patient->dusun }}</p>
            <p><strong>Agama:</strong> {{ $patient->agama }}</p>
            <p><strong>Pendidikan:</strong> {{ $patient->pendidikan }}</p>
            <p><strong>Pekerjaan:</strong> {{ $patient->pekerjaan }}</p>
        </div>
    </div>
</div>
@endsection
