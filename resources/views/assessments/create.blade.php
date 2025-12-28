@extends('layouts.app')
@section('title', 'Tambah Assessment')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Assessment — {{ $patient->nama_lengkap }}</h1>
    <p class="text-sm text-gray-500 mb-6">Kunjungan ke-{{ $patient->assessments()->count() + 1 }}</p>

    <form id="assessmentForm" action="{{ route('assessments.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        {{-- hidden --}}
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        <input type="hidden" name="kunjungan_ke" value="{{ $patient->assessments()->count() + 1 }}">
        <input type="hidden" name="petugas_id" value="{{ auth()->id() }}">

        {{-- TABS --}}
        <div class="mb-4">
            <nav class="flex gap-2" id="tabs">
                <button type="button" data-target="tab-patient" class="tab-btn px-3 py-2 rounded bg-blue-600 text-white text-sm">1. Data Pasien</button>
                <button type="button" data-target="tab-anamnesa" class="tab-btn px-3 py-2 rounded bg-gray-100 text-sm">2. Anamnesa & Pemeriksaan</button>
                <button type="button" data-target="tab-soap" class="tab-btn px-3 py-2 rounded bg-gray-100 text-sm">3. SOAP & Diagnosa</button>
                <button type="button" data-target="tab-procmed" class="tab-btn px-3 py-2 rounded bg-gray-100 text-sm">4. Tindakan & Obat</button>
                <button type="button" data-target="tab-other" class="tab-btn px-3 py-2 rounded bg-gray-100 text-sm">5. Lain-lain</button>
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
                        <input type="text" value="{{ $patient->no_rm ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Nama Lengkap</label>
                        <input type="text" value="{{ $patient->nama_lengkap }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Tanggal Lahir</label>
                        <input type="text" value="{{ $patient->tanggal_lahir ? \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d M Y') : '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Usia</label>
                        <input type="text" value="{{ $patient->umur ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Jenis Kelamin</label>
                        <input type="text" value="{{ $patient->jenis_kelamin ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Pekerjaan</label>
                        <input type="text" value="{{ $patient->pekerjaan ?? '-' }}" readonly class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600">Alamat</label>
                        <textarea readonly class="w-full bg-gray-100 border rounded p-2" rows="2">{{ $patient->alamat ?? '-' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- TAB 2: ANAMNESA & PEMERIKSAAN --}}
            <div id="tab-anamnesa" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">Asuhan Keperawatan</h2>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Keluhan Utama</label>
                    <textarea name="keluhan" rows="2" class="w-full border rounded p-2">{{ old('keluhan') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Anamnesa</label>
                    <textarea name="anamnesa" rows="3" class="w-full border rounded p-2">{{ old('anamnesa') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">Terapi Non Obat</label>
                    <textarea name="terapi_non_obat" rows="2" class="w-full border rounded p-2">{{ old('terapi_non_obat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Prognosa</label>
                        <select name="prognosa" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            @foreach($prognosaOptions as $opt)
                                <option value="{{ $opt }}" {{ old('prognosa') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Kesadaran</label>
                        <select name="kesadaran" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            @foreach($kesadaranOptions as $opt)
                                <option value="{{ $opt }}" {{ old('kesadaran') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h3 class="font-medium mb-2">Pemeriksaan Fisik</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Tinggi Badan (cm)</label>
                        <input id="tinggi_badan" type="number" name="tinggi_badan" step="0.1" min="0" class="w-full border rounded p-2" value="{{ old('tinggi_badan') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Berat Badan (kg)</label>
                        <input id="berat_badan" type="number" name="berat_badan" step="0.1" min="0" class="w-full border rounded p-2" value="{{ old('berat_badan') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">IMT</label>
                        <input id="imt" name="imt" readonly class="w-full bg-gray-100 border rounded p-2" value="{{ old('imt') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">LILA (cm)</label>
                        <input type="number" name="lila" step="0.1" min="0" class="w-full border rounded p-2" value="{{ old('lila') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Lingkar Perut (cm)</label>
                        <input type="number" name="lingkar_perut" step="0.1" min="0" class="w-full border rounded p-2" value="{{ old('lingkar_perut') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Lingkar Kepala (cm)</label>
                        <input type="number" name="lingkar_kepala" step="0.1" min="0" class="w-full border rounded p-2" value="{{ old('lingkar_kepala') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">GDS (mg/dL)</label>
                        <input type="number" name="gds"  min="0" class="w-full border rounded p-2" value="{{ old('gds') }}">
                    </div>
                </div>

                <h3 class="font-medium mb-2">Tanda Vital</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Tekanan Darah - Sistolik</label>
                        <input
                            type="number"
                            name="tekanan_sistolik"
                            min="0"
                            class="w-full border rounded p-2"
                            value="{{ old('tekanan_sistolik') }}"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Tekanan Darah - Diastolik</label>
                        <input
                            type="number"
                            name="tekanan_diastolik"
                            min="0"
                            class="w-full border rounded p-2"
                            value="{{ old('tekanan_diastolik') }}"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Respiratory Rate (RR)</label>
                        <input
                            type="number"
                            name="rr"
                            min="0"
                            class="w-full border rounded p-2"
                            value="{{ old('rr') }}"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Heart Rate (HR)</label>
                        <input
                            type="number"
                            name="hr"
                            min="0"
                            class="w-full border rounded p-2"
                            value="{{ old('hr') }}"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Suhu (°C)</label>
                        <input
                            type="number"
                            step="0.1"
                            min="0"
                            name="suhu"
                            class="w-full border rounded p-2"
                            value="{{ old('suhu') }}"
                        >
                    </div>
                </div>


                <h3 class="font-medium mb-2">Riwayat Alergi</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Makanan</label>
                        <input type="text" name="alergi_makanan" class="w-full border rounded p-2" value="{{ old('alergi_makanan') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Udara</label>
                        <input type="text" name="alergi_udara" class="w-full border rounded p-2" value="{{ old('alergi_udara') }}">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Obat</label>
                        <input type="text" name="alergi_obat" class="w-full border rounded p-2" value="{{ old('alergi_obat') }}">
                    </div>
                </div>
            </div>

            {{-- TAB 3: SOAP & DIAGNOSA --}}
            <div id="tab-soap" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">SOAP</h2>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Subjektif</label>
                    <textarea name="soap_subjektif" rows="2" class="w-full border rounded p-2">{{ old('soap_subjektif') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Objektif</label>
                    <textarea name="soap_objektif" rows="2" class="w-full border rounded p-2">{{ old('soap_objektif') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Assesmen</label>
                    <textarea name="soap_assesmen" rows="2" class="w-full border rounded p-2">{{ old('soap_assesmen') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600">SOAP - Perencanaan</label>
                    <textarea name="soap_perencanaan" rows="2" class="w-full border rounded p-2">{{ old('soap_perencanaan') }}</textarea>
                </div>

                {{-- Diagnosa Dynamic --}}
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium">Diagnosa</h3>
                        <button type="button" id="addDiagnosisBtn" class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                            + Tambah Diagnosa
                        </button>
                    </div>

                    <div id="diagnosesWrapper" class="space-y-3">
                        {{-- ROW PERTAMA --}}
                        <div class="diagnosis-row grid grid-cols-12 gap-2 items-end">
                            <div class="col-span-8">
                                <label class="text-xs text-gray-600">Diagnosa</label>
                                <input type="text" 
                                    name="diagnoses[0][diagnosa]" 
                                    class="diagnosis-input w-full border rounded p-2 text-sm"
                                    value="{{ old('diagnoses.0.diagnosa') }}"
                                    placeholder="Ketik diagnosa...">
                            </div>

                            <div class="col-span-3">
                                <label class="text-xs text-gray-600">Kategori</label>
                                <select name="diagnoses[0][kategori]" class="diagnosis-kategori w-full border rounded p-2 text-sm">
                                    <option value="utama" {{ old('diagnoses.0.kategori') == 'utama' ? 'selected' : '' }}>utama</option>
                                    <option value="sekunder" {{ old('diagnoses.0.kategori') == 'sekunder' ? 'selected' : '' }}>Sekunder</option>
                                </select>
                            </div>

                            <div class="col-span-1">
                                <button type="button" class="remove-diagnosis text-red-600 text-sm mt-1 hidden">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 4: TINDAKAN & OBAT --}}
            <div id="tab-procmed" class="tab-panel hidden">
                <h2 class="font-semibold mb-3">Tindakan</h2>

                {{-- Tindakan dynamic --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium">Tindakan / Prosedur</h3>
                        <button type="button" id="addProcBtn" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                            + Tambah Tindakan
                        </button>
                    </div>

                    <div id="proceduresWrapper" class="space-y-2">
                        <div class="proc-row grid grid-cols-12 gap-2 items-end">
                            <div class="col-span-5">
                                <label class="text-xs text-gray-600">Tindakan</label>
                                <select name="procedures[0][tindakan]" class="proc-select w-full border rounded p-2 text-sm">
                                    <option value="">-- pilih --</option>
                                    <option value="Pemeriksaan fisik umum">Pemeriksaan fisik umum</option>
                                    <option value="Laboratorium">Laboratorium</option>
                                    <option value="Injeksi">Injeksi</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-gray-600">Jumlah</label>
                                <input type="number" name="procedures[0][jumlah]" class="jumlah-input w-full border rounded p-2 text-sm" value="{{ old('procedures.0.jumlah', 1) }}" min="1">
                            </div>
                            <div class="col-span-3">
                                <label class="text-xs text-gray-600">Pembayaran</label>
                                <select name="procedures[0][pembayaran]" class="w-full border rounded p-2 text-sm">
                                    <option value="bayar" {{ old('procedures.0.pembayaran') == 'bayar' ? 'selected' : '' }}>Bayar</option>
                                    <option value="gratis" {{ old('procedures.0.pembayaran') == 'gratis' ? 'selected' : '' }}>Gratis</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-gray-600">Harga (opsional)</label>
                                <input type="number" name="procedures[0][harga]" class="harga-input w-full border rounded p-2 text-sm" step="0.01" value="{{ old('procedures.0.harga') }}">
                            </div>
                            <div class="col-span-12">
                                <button type="button" class="remove-proc text-red-600 text-sm mt-1 hidden">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Obat dynamic --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium">Obat</h3>
                        <button type="button" id="addMedBtn" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                            + Tambah Obat
                        </button>
                    </div>

                    <div id="medsWrapper" class="space-y-2">
                        <div class="med-row grid grid-cols-12 gap-2 items-end">
                            <div class="col-span-5">
                                <label class="text-xs text-gray-600">Nama Obat</label>
                                <input type="text" 
                                    name="medications[0][nama_obat]" 
                                    class="med-input w-full border rounded p-2 text-sm"
                                    value="{{ old('medications.0.nama_obat') }}"
                                    placeholder="Ketik nama obat...">
                            </div>

                            <div class="col-span-2">
                                <label class="text-xs text-gray-600">Jenis</label>
                                <select name="medications[0][jenis]" class="w-full border rounded p-2 text-sm">
                                    <option value="non_racikan" {{ old('medications.0.jenis') == 'non_racikan' ? 'selected' : '' }}>Non-Racikan</option>
                                    <option value="racikan" {{ old('medications.0.jenis') == 'racikan' ? 'selected' : '' }}>Racikan</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-gray-600">Dosis</label>
                                <input type="text" name="medications[0][dosis]" class="med-dosis-input w-full border rounded p-2 text-sm" value="{{ old('medications.0.dosis') }}">
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-gray-600">Jumlah</label>
                                <input type="number" name="medications[0][jumlah]" class="med-jumlah-input w-full border rounded p-2 text-sm" value="{{ old('medications.0.jumlah', 1) }}" min="1">
                            </div>
                            <div class="col-span-12">
                                <button type="button" class="remove-med text-red-600 text-sm mt-1 hidden">Hapus</button>
                            </div>
                        </div>
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
                            <option {{ old('kategori_kunjungan') == 'Poliklinik' ? 'selected' : '' }}>Poliklinik</option>
                            <option {{ old('kategori_kunjungan') == 'UGD' ? 'selected' : '' }}>UGD</option>
                            <option {{ old('kategori_kunjungan') == 'Kontrol' ? 'selected' : '' }}>Kontrol</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Tindak Lanjut</label>
                        <select name="tindak_lanjut" class="w-full border rounded p-2">
                            <option value="">-- pilih --</option>
                            <option value="rawat_jalan" {{ old('tindak_lanjut') == 'rawat_jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                            <option value="rujuk_internal" {{ old('tindak_lanjut') == 'rujuk_internal' ? 'selected' : '' }}>Rujuk Internal</option>
                            <option value="rujuk" {{ old('tindak_lanjut') == 'rujuk' ? 'selected' : '' }}>Rujuk</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Catatan / Keterangan</label>
                        <input type="text" name="catatan" class="w-full border rounded p-2" value="{{ old('catatan') }}">
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
                <a href="{{ route('assessments.history', $patient->id) }}" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 text-sm">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan Assessment</button>
                <button type="button" id="nextBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Next</button>
            </div>
        </div>
    </form>
</div>

{{-- SCRIPTS: Tabs, IMT, dynamic rows --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Tabs ---
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
        document.getElementById('prevBtn').style.display = idx === 0 ? 'none' : 'inline-block';
        document.getElementById('nextBtn').style.display = idx === tabPanels.length - 1 ? 'none' : 'inline-block';
        tabButtons[idx].scrollIntoView({behavior: 'smooth', inline: 'center'});
    }

    const targetIndexMap = {};
    tabPanels.forEach((panel, i) => targetIndexMap[panel.id] = i);
    tabButtons.forEach(btn => btn.addEventListener('click', () => {
        const t = btn.dataset.target;
        showTabByIndex(targetIndexMap[t] ?? 0);
    }));
    showTabByIndex(0);
    document.getElementById('nextBtn').addEventListener('click', () => { if (currentTabIndex < tabPanels.length -1) showTabByIndex(currentTabIndex + 1); });
    document.getElementById('prevBtn').addEventListener('click', () => { if (currentTabIndex > 0) showTabByIndex(currentTabIndex - 1); });

    // --- IMT realtime ---
    const tbInput = document.getElementById('tinggi_badan');
    const bbInput = document.getElementById('berat_badan');
    const imtInput = document.getElementById('imt');

    function hitungIMT() {
        const tbVal = parseFloat(tbInput?.value || 0);
        const bbVal = parseFloat(bbInput?.value || 0);
        if (tbVal > 0 && bbVal > 0) {
            const tbMeters = tbVal / 100;
            const imt = bbVal / (tbMeters * tbMeters);
            imtInput.value = isFinite(imt) ? imt.toFixed(2) : '';
        } else imtInput.value = '';
    }
    if (tbInput && bbInput) {
        tbInput.addEventListener('input', hitungIMT);
        bbInput.addEventListener('input', hitungIMT);
        hitungIMT();
    }

    // --- Diagnoses dynamic rows ---
    const diagnosesWrapper = document.getElementById('diagnosesWrapper');
    const addDiagnosisBtn = document.getElementById('addDiagnosisBtn');

    function reindexDiagnoses() {
        const rows = Array.from(diagnosesWrapper.querySelectorAll('.diagnosis-row'));
        rows.forEach((row, idx) => {
            const diagnosa = row.querySelector('.diagnosis-input');
            const kategori = row.querySelector('.diagnosis-kategori');
            if (diagnosa) diagnosa.name = `diagnoses[${idx}][diagnosa]`;
            if (kategori) kategori.name = `diagnoses[${idx}][kategori]`;
            const removeBtn = row.querySelector('.remove-diagnosis');
            if (removeBtn) removeBtn.classList.toggle('hidden', rows.length <= 1);
        });
    }

    function bindDiagnosisRow(row) {
        const removeBtn = row.querySelector('.remove-diagnosis');
        removeBtn?.addEventListener('click', () => {
            row.remove();
            reindexDiagnoses();
        });
    }

    addDiagnosisBtn.addEventListener('click', () => {
        const firstRow = diagnosesWrapper.querySelector('.diagnosis-row');
        const newRow = firstRow.cloneNode(true);
        // newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        newRow.querySelectorAll('input').forEach(i => i.value = '');
        newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        diagnosesWrapper.appendChild(newRow);
        bindDiagnosisRow(newRow);
        reindexDiagnoses();
    });

    diagnosesWrapper.querySelectorAll('.diagnosis-row').forEach(r => bindDiagnosisRow(r));
    reindexDiagnoses();

    // --- Procedures dynamic rows ---
    const procsWrapper = document.getElementById('proceduresWrapper');
    const addProcBtn = document.getElementById('addProcBtn');

    function reindexProcs() {
        const rows = Array.from(procsWrapper.querySelectorAll('.proc-row'));
        rows.forEach((row, idx) => {
            row.querySelectorAll('input[name], select[name]').forEach(el => {
                if (el.name) el.name = el.name.replace(/procedures\[\d+\]/, `procedures[${idx}]`);
            });
            row.querySelectorAll('.remove-proc').forEach(b => b.classList.toggle('hidden', rows.length <= 1));
        });
    }

    function bindProcRow(row) {
        const sel = row.querySelector('.proc-select');
        const removeBtn = row.querySelector('.remove-proc');
        sel?.addEventListener('change', () => {
            // nothing extra required (select already has name procedures[x][tindakan])
        });
        removeBtn?.addEventListener('click', () => {
            row.remove();
            reindexProcs();
        });
    }

    addProcBtn.addEventListener('click', () => {
        const template = procsWrapper.querySelector('.proc-row').cloneNode(true);
        template.querySelectorAll('input').forEach(i => i.value = '');
        template.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        procsWrapper.appendChild(template);
        bindProcRow(template);
        reindexProcs();
    });

    procsWrapper.querySelectorAll('.proc-row').forEach(r => bindProcRow(r));
    reindexProcs();

    // --- Medications dynamic rows ---
    const medsWrapper = document.getElementById('medsWrapper');
    const addMedBtn = document.getElementById('addMedBtn');

    function reindexMeds() {
        const rows = Array.from(medsWrapper.querySelectorAll('.med-row'));
        rows.forEach((row, idx) => {
            row.querySelectorAll('input[name], select[name]').forEach(el => {
                if (el.name) el.name = el.name.replace(/medications\[\d+\]/, `medications[${idx}]`);
            });
            row.querySelectorAll('.remove-med').forEach(b => b.classList.toggle('hidden', rows.length <= 1));
        });
    }

    function bindMedRow(row) {
        const sel = row.querySelector('.med-select');
        const dosisInput = row.querySelector('.med-dosis-input');
        const removeBtn = row.querySelector('.remove-med');

        sel?.addEventListener('change', function() {
            const opt = sel.selectedOptions[0];
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
        bindMedRow(template);
        reindexMeds();
    });

    medsWrapper.querySelectorAll('.med-row').forEach(r => bindMedRow(r));
    reindexMeds();

    // Hide prev initially
    document.getElementById('prevBtn').style.display = 'none';
});
</script>
@endsection
