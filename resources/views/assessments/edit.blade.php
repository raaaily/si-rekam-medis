@extends('layouts.app')
@section('title', 'Edit Assessment')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Assessment — {{ $assessment->patient->nama_lengkap }}</h1>
    <p class="text-sm text-gray-500 mb-6">Kunjungan ke-{{ $assessment->kunjungan_ke }}</p>

    <form id="assessmentForm" action="{{ route('assessments.update', $assessment->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf
        @method('PUT')

        <input type="hidden" name="patient_id" value="{{ $assessment->patient_id }}">
        <input type="hidden" name="petugas_id" value="{{ $assessment->petugas_id }}">

        {{-- TABS --}}
        <div class="mb-4">
            <nav class="flex gap-2" id="tabs">
                @php
                    $tabs = [
                        'tab-patient'=>'1. Data Pasien',
                        'tab-anamnesa'=>'2. Anamnesa & Pemeriksaan',
                        'tab-soap'=>'3. SOAP & Diagnosa',
                        'tab-procmed'=>'4. Tindakan & Obat',
                        'tab-other'=>'5. Lain-lain'
                    ];
                @endphp
                @foreach($tabs as $id => $label)
                    <button type="button" data-target="{{ $id }}" class="tab-btn px-3 py-2 rounded @if($loop->first) bg-blue-600 text-white @else bg-gray-100 text-gray-800 @endif text-sm">{{ $label }}</button>
                @endforeach
            </nav>
        </div>

        {{-- TAB CONTENTS --}}
        <div>
            {{-- TAB 1: DATA PASIEN --}}
            <div id="tab-patient" class="tab-panel">
                <h2 class="font-semibold mb-3">Data Pasien</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600">Nomor RM</label>
                        <input type="text" value="{{ $assessment->patient->no_rm ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Nama Lengkap</label>
                        <input type="text" value="{{ $assessment->patient->nama_lengkap }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Tanggal Lahir</label>
                        <input type="text" value="{{ $assessment->patient->tanggal_lahir ? \Carbon\Carbon::parse($assessment->patient->tanggal_lahir)->format('d M Y') : '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Usia</label>
                        <input type="text" value="{{ $assessment->patient->umur ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Jenis Kelamin</label>
                        <input type="text" value="{{ $assessment->patient->jenis_kelamin ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Pekerjaan</label>
                        <input type="text" value="{{ $assessment->patient->pekerjaan ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600">Alamat</label>
                        <textarea readonly class="w-full bg-gray-100 border rounded p-2" rows="2">{{ $assessment->patient->alamat ?? '-' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- TAB 2: ANAMNESA & PEMERIKSAAN --}}
            <div id="tab-anamnesa" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">Asuhan Keperawatan</h2>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Keluhan Utama</label>
                    <textarea name="keluhan" rows="2" class="w-full border rounded p-2">{{ old('keluhan', $assessment->keluhan) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Anamnesa</label>
                    <textarea name="anamnesa" rows="3" class="w-full border rounded p-2">{{ old('anamnesa', $assessment->anamnesa) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Terapi Non Obat</label>
                    <textarea name="terapi_non_obat" rows="2" class="w-full border rounded p-2">{{ old('terapi_non_obat', $assessment->terapi_non_obat) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Prognosa</label>
                        <select name="prognosa" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            @foreach($prognosaOptions as $opt)
                                <option value="{{ $opt }}" {{ $assessment->prognosa == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Kesadaran</label>
                        <select name="kesadaran" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            @foreach($kesadaranOptions as $opt)
                                <option value="{{ $opt }}" {{ $assessment->kesadaran == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Pemeriksaan Fisik --}}
                <h3 class="font-medium mb-2">Pemeriksaan Fisik</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Tinggi Badan (cm)</label>
                        <input id="tinggi_badan" type="number" name="tinggi_badan" step="0.1" class="w-full border rounded p-2" value="{{ old('tinggi_badan', $assessment->tinggi_badan) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Berat Badan (kg)</label>
                        <input id="berat_badan" type="number" name="berat_badan" step="0.1" class="w-full border rounded p-2" value="{{ old('berat_badan', $assessment->berat_badan) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">IMT</label>
                        <input id="imt" name="imt" readonly class="w-full bg-gray-100 border rounded p-2" value="{{ old('imt', $assessment->imt) }}">
                    </div>
                                        <div>
                        <label class="block text-sm text-gray-600">LILA (cm)</label>
                        <input type="number" name="lila" step="0.1" class="w-full border rounded p-2" value="{{ old('lila', $assessment->lila) }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Lingkar Perut (cm)</label>
                        <input type="number" name="lingkar_perut" step="0.1" class="w-full border rounded p-2" value="{{ old('lingkar_perut', $assessment->lingkar_perut) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Lingkar Kepala (cm)</label>
                        <input type="number" name="lingkar_kepala" step="0.1" class="w-full border rounded p-2" value="{{ old('lingkar_kepala', $assessment->lingkar_kepala) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">GDS (mg/dL)</label>
                        <input type="number" name="gds" class="w-full border rounded p-2" value="{{ old('gds', $assessment->gds) }}">
                    </div>
                </div>


                <h3 class="font-medium mb-2">Pemeriksaan Tanda Vital</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Tekanan Darah Sistolik</label>
                        <input type="number" name="tekanan_sistolik" class="w-full border rounded p-2" value="{{ old('tekanan_sistolik', $assessment->tekanan_sistolik) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Tekanan Darah Diastolik</label>
                        <input type="number" name="tekanan_diastolik" class="w-full border rounded p-2" value="{{ old('tekanan_diastolik', $assessment->tekanan_diastolik) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">RR</label>
                        <input type="number" name="rr" class="w-full border rounded p-2" value="{{ old('rr', $assessment->rr) }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">HR</label>
                        <input type="number" name="hr" class="w-full border rounded p-2" value="{{ old('hr', $assessment->hr) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Suhu (°C)</label>
                        <input type="number" step="0.1" name="suhu" class="w-full border rounded p-2" value="{{ old('suhu', $assessment->suhu) }}">
                    </div>
                </div>


                <h3 class="font-medium mb-2">Riwayat Alergi</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Makanan</label>
                        <input type="text" name="alergi_makanan" class="w-full border rounded p-2" value="{{ old('alergi_makanan', $assessment->alergi_makanan) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Udara</label>
                        <input type="text" name="alergi_udara" class="w-full border rounded p-2" value="{{ old('alergi_udara', $assessment->alergi_udara) }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Obat</label>
                        <input type="text" name="alergi_obat" class="w-full border rounded p-2" value="{{ old('alergi_obat', $assessment->alergi_obat) }}">
                    </div>
                </div>
            </div>

            {{-- TAB 3: SOAP & DIAGNOSA --}}
            <div id="tab-soap" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">SOAP & Diagnosa</h2>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Subjektif</label>
                    <textarea name="soap_subjektif" rows="2" class="w-full border rounded p-2">{{ old('soap_subjektif', $assessment->soap_subjektif) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Objektif</label>
                    <textarea name="soap_objektif" rows="2" class="w-full border rounded p-2">{{ old('soap_objektif', $assessment->soap_objektif) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Assesmen</label>
                    <textarea name="soap_assesmen" rows="2" class="w-full border rounded p-2">{{ old('soap_assesmen', $assessment->soap_assesmen) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Perencanaan</label>
                    <textarea name="soap_perencanaan" rows="2" class="w-full border rounded p-2">{{ old('soap_perencanaan', $assessment->soap_perencanaan) }}</textarea>
                </div>

                {{-- Diagnosa Dynamic Rows (EDIT) --}}
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium">Diagnosa</h3>
                        <button type="button"
                                id="addDiagnosisBtn"
                                class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                            + Tambah Diagnosa
                        </button>
                    </div>

                    <div id="diagnosesWrapper" class="space-y-2">
                        @forelse($assessment->diagnoses as $i => $diag)
                        <div class="diagnosis-row grid grid-cols-12 gap-2 items-end">
                            {{-- Diagnosa --}}
                            <div class="col-span-8">
                                <label class="text-xs text-gray-600">Diagnosa</label>
                                <input type="text"
                                    name="diagnoses[{{ $i }}][diagnosa]"
                                    class="w-full border rounded p-2 text-sm"
                                    value="{{ old("diagnoses.$i.diagnosa", $diag->diagnosa) }}"
                                    placeholder="Ketik diagnosa...">
                            </div>

                            {{-- Kategori --}}
                            <div class="col-span-3">
                                <label class="text-xs text-gray-600">Kategori</label>
                                <select name="diagnoses[{{ $i }}][kategori]"
                                        class="w-full border rounded p-2 text-sm">
                                    <option value="utama" {{ $diag->kategori == 'utama' ? 'selected' : '' }}>
                                        Utama
                                    </option>
                                    <option value="sekunder" {{ $diag->kategori == 'sekunder' ? 'selected' : '' }}>
                                        Sekunder
                                    </option>
                                </select>
                            </div>

                            {{-- Remove --}}
                            <div class="col-span-1">
                                <button type="button"
                                        class="remove-diagnosis text-red-600 text-sm mt-1">
                                    Hapus
                                </button>
                            </div>
                        </div>
                        @empty
                        {{-- Jika belum ada diagnosa --}}
                        <div class="diagnosis-row grid grid-cols-12 gap-2 items-end">
                            <div class="col-span-8">
                                <label class="text-xs text-gray-600">Diagnosa</label>
                                <input type="text"
                                    name="diagnoses[0][diagnosa]"
                                    class="w-full border rounded p-2 text-sm"
                                    placeholder="Ketik diagnosa...">
                            </div>

                            <div class="col-span-3">
                                <label class="text-xs text-gray-600">Kategori</label>
                                <select name="diagnoses[0][kategori]"
                                        class="w-full border rounded p-2 text-sm">
                                    <option value="utama">Utama</option>
                                    <option value="sekunder">Sekunder</option>
                                </select>
                            </div>

                            <div class="col-span-1">
                                <button type="button"
                                        class="remove-diagnosis text-red-600 text-sm mt-1 hidden">
                                    Hapus
                                </button>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- TAB 4: TINDAKAN & OBAT --}}
            <div id="tab-procmed" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">Tindakan & Obat</h2>

                {{-- ================= TINDAKAN ================= --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium">Tindakan / Prosedur</h3>
                        <button type="button" id="addProcBtn"
                            class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                            + Tambah Tindakan
                        </button>
                    </div>

                    <div id="proceduresWrapper" class="space-y-2">
                        @forelse($assessment->procedures as $i => $p)
                <div class="proc-row grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-5">
                        <label class="text-xs text-gray-600">Tindakan</label>
                        <input type="text"
                               name="procedures[{{ $i }}][tindakan]"
                               class="w-full border rounded p-2 text-sm"
                               value="{{ old("procedures.$i.tindakan", $p->tindakan) }}">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Jumlah</label>
                        <input type="number"
                               name="procedures[{{ $i }}][jumlah]"
                               class="w-full border rounded p-2 text-sm"
                               min="1"
                               value="{{ old("procedures.$i.jumlah", $p->jumlah) }}">
                    </div>

                    <div class="col-span-3">
                        <label class="text-xs text-gray-600">Pembayaran</label>
                        <input type="text"
                               name="procedures[{{ $i }}][pembayaran]"
                               class="w-full border rounded p-2 text-sm"
                               value="{{ old("procedures.$i.pembayaran", $p->pembayaran) }}">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Harga</label>
                        <input type="number"
                               name="procedures[{{ $i }}][harga]"
                               class="w-full border rounded p-2 text-sm"
                               value="{{ old("procedures.$i.harga", $p->harga) }}">
                    </div>

                    <div class="col-span-12">
                        <button type="button" class="remove-proc text-red-600 text-sm">
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                {{-- fallback kalau belum ada data --}}
                <div class="proc-row grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-5">
                        <label class="text-xs text-gray-600">Tindakan</label>
                        <input type="text"
                               name="procedures[0][tindakan]"
                               class="w-full border rounded p-2 text-sm">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Jumlah</label>
                        <input type="number"
                               name="procedures[0][jumlah]"
                               class="w-full border rounded p-2 text-sm"
                               value="1" min="1">
                    </div>

                    <div class="col-span-3">
                        <label class="text-xs text-gray-600">Pembayaran</label>
                        <input type="text"
                               name="procedures[0][pembayaran]"
                               class="w-full border rounded p-2 text-sm">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Harga</label>
                        <input type="number"
                               name="procedures[0][harga]"
                               class="w-full border rounded p-2 text-sm">
                    </div>

                    <div class="col-span-12">
                        <button type="button" class="remove-proc hidden text-red-600 text-sm">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ================= OBAT ================= --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-medium">Obat</h3>
            <button type="button" id="addMedBtn"
                class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                + Tambah Obat
            </button>
        </div>

        <div id="medsWrapper" class="space-y-2">
            @forelse($assessment->medications as $i => $m)
                <div class="med-row grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-5">
                        <label class="text-xs text-gray-600">Nama Obat</label>
                        <input type="text"
                               name="medications[{{ $i }}][nama_obat]"
                               class="w-full border rounded p-2 text-sm"
                               value="{{ old("medications.$i.nama_obat", $m->nama_obat) }}">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Jenis</label>
                        <select name="medications[{{ $i }}][jenis]"
                                class="w-full border rounded p-2 text-sm">
                            <option value="non_racikan" {{ $m->jenis=='non_racikan'?'selected':'' }}>
                                Non-Racikan
                            </option>
                            <option value="racikan" {{ $m->jenis=='racikan'?'selected':'' }}>
                                Racikan
                            </option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Dosis</label>
                        <input type="text"
                               name="medications[{{ $i }}][dosis]"
                               class="w-full border rounded p-2 text-sm"
                               value="{{ old("medications.$i.dosis", $m->dosis) }}">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Jumlah</label>
                        <input type="number"
                               name="medications[{{ $i }}][jumlah]"
                               class="w-full border rounded p-2 text-sm"
                               min="1"
                               value="{{ old("medications.$i.jumlah", $m->jumlah) }}">
                    </div>

                    <div class="col-span-12">
                        <button type="button" class="remove-med text-red-600 text-sm">
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="med-row grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-5">
                        <label class="text-xs text-gray-600">Nama Obat</label>
                        <input type="text"
                               name="medications[0][nama_obat]"
                               class="w-full border rounded p-2 text-sm">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Jenis</label>
                        <select name="medications[0][jenis]"
                                class="w-full border rounded p-2 text-sm">
                            <option value="non_racikan">Non-Racikan</option>
                            <option value="racikan">Racikan</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Dosis</label>
                        <input type="text"
                               name="medications[0][dosis]"
                               class="w-full border rounded p-2 text-sm">
                    </div>

                    <div class="col-span-2">
                        <label class="text-xs text-gray-600">Jumlah</label>
                        <input type="number"
                               name="medications[0][jumlah]"
                               class="w-full border rounded p-2 text-sm"
                               value="1" min="1">
                    </div>

                    <div class="col-span-12">
                        <button type="button" class="remove-med hidden text-red-600 text-sm">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>


            {{-- TAB 5: LAIN-LAIN --}}
            <div id="tab-other" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">Lain-lain</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Petugas Medis</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Kategori Kunjungan</label>
                        <select name="kategori_kunjungan" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            <option {{ $assessment->kategori_kunjungan == 'Poliklinik' ? 'selected' : '' }}>Poliklinik</option>
                            <option {{ $assessment->kategori_kunjungan == 'UGD' ? 'selected' : '' }}>UGD</option>
                            <option {{ $assessment->kategori_kunjungan == 'Kontrol' ? 'selected' : '' }}>Kontrol</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Tindak Lanjut</label>
                        <select name="tindak_lanjut" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            <option value="rawat_jalan" {{ $assessment->tindak_lanjut == 'rawat_jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                            <option value="rujuk_internal" {{ $assessment->tindak_lanjut == 'rujuk_internal' ? 'selected' : '' }}>Rujuk Internal</option>
                            <option value="rujuk" {{ $assessment->tindak_lanjut == 'rujuk' ? 'selected' : '' }}>Rujuk</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Catatan / Keterangan</label>
                        <input type="text" name="catatan" class="w-full border rounded p-2" value="{{ old('catatan', $assessment->catatan) }}">
                    </div>
                </div>
            </div>

        </div>

        {{-- NAV BUTTONS --}}
        <div class="flex items-center justify-between mt-4">
            <div>
                <button type="button" id="prevBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">Previous</button>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('assessments.history', $assessment->patient_id) }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 text-sm">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Update Assessment</button>
                <button type="button" id="nextBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Next</button>
            </div>
        </div>
    </form>
</div>

{{-- SCRIPTS: Tabs, IMT, dynamic rows --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Tabs (improved: use data-target) ---
    const tabButtons = Array.from(document.querySelectorAll('.tab-btn'));
    const tabPanels = Array.from(document.querySelectorAll('.tab-panel'));
    let currentTabIndex = 0;

    function showTabByIndex(idx) {
        tabPanels.forEach((p, i) => p.classList.toggle('hidden', i !== idx));
        tabButtons.forEach((b, i) => {
            b.classList.toggle('bg-blue-600', i === idx);
            b.classList.toggle('text-white', i === idx);
            b.classList.toggle('bg-gray-100', i !== idx);
        });
        currentTabIndex = idx;
        // prev/next visibility
        document.getElementById('prevBtn').style.display = idx === 0 ? 'none' : 'inline-block';
        document.getElementById('nextBtn').style.display = idx === tabPanels.length - 1 ? 'none' : 'inline-block';
        // scroll into view a little (optional)
        tabButtons[idx].scrollIntoView({behavior: 'smooth', inline: 'center'});
    }

    // map data-target to panel index for robustness
    const targetIndexMap = {};
    tabPanels.forEach((panel, i) => {
        targetIndexMap[panel.id] = i;
    });

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const target = btn.dataset.target;
            const idx = typeof targetIndexMap[target] !== 'undefined' ? targetIndexMap[target] : 0;
            showTabByIndex(idx);
        });
    });

    showTabByIndex(0); // initial

    document.getElementById('nextBtn').addEventListener('click', function(){
        if (currentTabIndex < tabPanels.length - 1) showTabByIndex(currentTabIndex + 1);
    });
    document.getElementById('prevBtn').addEventListener('click', function(){
        if (currentTabIndex > 0) showTabByIndex(currentTabIndex - 1);
    });

    // --- IMT realtime (robust) ---
    const tbInput = document.getElementById('tinggi_badan');
    const bbInput = document.getElementById('berat_badan');
    const imtInput = document.getElementById('imt');

    function hitungIMT() {
        const tbVal = parseFloat(tbInput?.value || 0);
        const bbVal = parseFloat(bbInput?.value || 0);
        if (tbVal > 0 && bbVal > 0) {
            const tbMeters = tbVal / 100; // cm -> m
            const imt = bbVal / (tbMeters * tbMeters);
            if (isFinite(imt)) imtInput.value = imt.toFixed(2);
            else imtInput.value = '';
        } else {
            imtInput.value = '';
        }
    }
    if (tbInput && bbInput) {
        tbInput.addEventListener('input', hitungIMT);
        bbInput.addEventListener('input', hitungIMT);
        // compute initially if values present
        hitungIMT();
    }

    // --- Diagnoses dynamic rows (simpler & robust) ---
    const diagnosesWrapper = document.getElementById('diagnosesWrapper');
    const addDiagnosisBtn = document.getElementById('addDiagnosisBtn');

    function reindexDiagnoses() {
        diagnosesWrapper.querySelectorAll('.diagnosis-row').forEach((row, idx) => {
            // update names for select & category select
            const select = row.querySelector('.diagnosis-select');
            if (select) select.name = `diagnoses[${idx}][diagnosa]`;
            const kategori = row.querySelector('select[name^="diagnoses"][name$="[kategori]"]') || row.querySelectorAll('select')[1];
            if (kategori) kategori.name = `diagnoses[${idx}][kategori]`;
            const removeBtn = row.querySelector('.remove-diagnosis');
            if (removeBtn) removeBtn.classList.toggle('hidden', diagnosesWrapper.querySelectorAll('.diagnosis-row').length <= 1);
        });
    }

    function bindDiagnosisRow(row) {
        const removeBtn = row.querySelector('.remove-diagnosis');
        removeBtn?.addEventListener('click', function() {
            row.remove();
            reindexDiagnoses();
        });
    }

    addDiagnosisBtn.addEventListener('click', function() {
        const template = diagnosesWrapper.querySelector('.diagnosis-row').cloneNode(true);
        // reset selects/inputs
        template.querySelectorAll('select, input').forEach(el => {
            if (el.tagName.toLowerCase() === 'select') el.selectedIndex = 0;
            else el.value = '';
        });
        diagnosesWrapper.appendChild(template);
        reindexDiagnoses();
        bindDiagnosisRow(template);
    });

    diagnosesWrapper.querySelectorAll('.diagnosis-row').forEach(r => bindDiagnosisRow(r));
    reindexDiagnoses();

    // --- Procedures dynamic rows ---
    const procsWrapper = document.getElementById('proceduresWrapper');
    const addProcBtn = document.getElementById('addProcBtn');

    function reindexProcs() {
        procsWrapper.querySelectorAll('.proc-row').forEach((row, idx) => {
            row.querySelectorAll('input[name], select[name]').forEach(el => {
                if (el.name) el.name = el.name.replace(/procedures\[\d+\]/, `procedures[${idx}]`);
            });
            row.querySelectorAll('.remove-proc').forEach(b => b.classList.toggle('hidden', procsWrapper.querySelectorAll('.proc-row').length <= 1));
        });
    }

    function bindProcRow(row) {
        const sel = row.querySelector('.proc-select');
        const nameHidden = row.querySelector('.proc-name-input');
        const removeBtn = row.querySelector('.remove-proc');

        sel?.addEventListener('change', function() {
            nameHidden.value = sel.selectedOptions[0]?.textContent || '';
        });

        removeBtn?.addEventListener('click', function() {
            row.remove();
            reindexProcs();
        });
    }

    addProcBtn.addEventListener('click', function() {
        const template = procsWrapper.querySelector('.proc-row').cloneNode(true);
        template.querySelectorAll('input').forEach(i => i.value = '');
        template.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        procsWrapper.appendChild(template);
        reindexProcs();
        bindProcRow(template);
    });
    procsWrapper.querySelectorAll('.proc-row').forEach(r => bindProcRow(r));
    reindexProcs();

    // --- Medications dynamic rows ---
    const medsWrapper = document.getElementById('medsWrapper');
    const addMedBtn = document.getElementById('addMedBtn');

    function reindexMeds() {
        medsWrapper.querySelectorAll('.med-row').forEach((row, idx) => {
            row.querySelectorAll('input[name], select[name]').forEach(el => {
                if (el.name) el.name = el.name.replace(/medications\[\d+\]/, `medications[${idx}]`);
            });
            row.querySelectorAll('.remove-med').forEach(b => b.classList.toggle('hidden', medsWrapper.querySelectorAll('.med-row').length <= 1));
        });
    }

    function bindMedRow(row) {
        const sel = row.querySelector('.med-select');
        const kodeHidden = row.querySelector('.med-kode-input');
        const dosisInput = row.querySelector('.med-dosis-input');
        const removeBtn = row.querySelector('.remove-med');

        sel?.addEventListener('change', function() {
            const opt = sel.selectedOptions[0];
            // set kode hidden & dosis if present
            if (kodeHidden) kodeHidden.value = opt?.dataset?.kode || '';
            if (dosisInput && opt?.dataset?.dosis) dosisInput.value = opt.dataset.dosis;
        });

        removeBtn?.addEventListener('click', function() {
            row.remove();
            reindexMeds();
        });
    }

    addMedBtn.addEventListener('click', function() {
        const template = medsWrapper.querySelector('.med-row').cloneNode(true);
        template.querySelectorAll('input').forEach(i => i.value = '');
        template.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        medsWrapper.appendChild(template);
        reindexMeds();
        bindMedRow(template);
    });
    medsWrapper.querySelectorAll('.med-row').forEach(r => bindMedRow(r));
    reindexMeds();

    // Hide prev initially
    document.getElementById('prevBtn').style.display = 'none';
});
</script>

@endsection
