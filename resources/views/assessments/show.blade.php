@extends('layouts.app')
@section('title', 'Detail Assessment')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-2">
        Detail Assessment — {{ $assessment->patient->nama_lengkap }}
    </h1>
    <p class="text-sm text-gray-500 mb-6">
        Kunjungan ke-{{ $assessment->kunjungan_ke ?? '-' }}
    </p>

    <div class="space-y-8 bg-white p-6 rounded-xl shadow">

        {{-- ================= DATA PASIEN ================= --}}
        <div>
            <h2 class="font-semibold mb-3">Data Pasien</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">No. RM</label>
                    <input readonly value="{{ $assessment->patient->no_rm ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Nama Lengkap</label>
                    <input readonly value="{{ $assessment->patient->nama_lengkap }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Tanggal Lahir</label>
                    <input readonly value="{{ $assessment->patient->tanggal_lahir ? \Carbon\Carbon::parse($assessment->patient->tanggal_lahir)->format('d M Y') : '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Usia</label>
                    <input readonly value="{{ $assessment->patient->umur ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Jenis Kelamin</label>
                    <input readonly value="{{ $assessment->patient->jenis_kelamin ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Pekerjaan</label>
                    <input readonly value="{{ $assessment->patient->pekerjaan ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Alamat</label>
                    <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->patient->alamat ?? '-' }}</textarea>
                </div>
            </div>
        </div>

        {{-- ================= ANAMNESA & PEMERIKSAAN ================= --}}
        <div>
            <h2 class="font-semibold mb-3">Asuhan Keperawatan</h2>

            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600">Keluhan Utama</label>
                    <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->keluhan }}</textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Anamnesa</label>
                    <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->anamnesa }}</textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Terapi Non Obat</label>
                    <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->terapi_non_obat }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Prognosa</label>
                        <input readonly value="{{ $assessment->prognosa }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Kesadaran</label>
                        <input readonly value="{{ $assessment->kesadaran }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                </div>

                {{-- Pemeriksaan Fisik --}}
                <h3 class="font-medium mb-2">Pemeriksaan Fisik</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Tinggi Badan (cm)</label>
                        <input readonly value="{{ $assessment->tinggi_badan }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Berat Badan (kg)</label>
                        <input readonly value="{{ $assessment->berat_badan }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">IMT</label>
                        <input readonly value="{{ $assessment->imt }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">LILA (cm)</label>
                        <input readonly value="{{ $assessment->lila }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Lingkar Perut (cm)</label>
                        <input readonly value="{{ $assessment->lingkar_perut }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Lingkar Kepala (cm)</label>
                        <input readonly value="{{ $assessment->lingkar_kepala }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">GDS (mg/dL)</label>
                        <input readonly value="{{ $assessment->gds }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                </div>

                {{-- Tanda Vital --}}
                <h3 class="font-medium mb-2">Pemeriksaan Tanda Vital</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Tekanan Darah - Sistolik</label>
                        <input readonly value="{{ $assessment->tekanan_sistolik }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Tekanan Darah - Diastolik</label>
                        <input readonly value="{{ $assessment->tekanan_diastolik }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Respiratory Rate (RR)</label>
                        <input readonly value="{{ $assessment->rr }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Heart Rate (HR)</label>
                        <input readonly value="{{ $assessment->hr }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Suhu (°C)</label>
                        <input readonly value="{{ $assessment->suhu }}" class="w-full bg-gray-100 border rounded p-2">
                    </div>
                </div>

                <h3 class="font-medium mb-2">Riwayat Alergi</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600">Alergi Makanan</label>
                        <input
                            type="text"
                            readonly
                            class="w-full bg-gray-100 border rounded p-2"
                            value="{{ $assessment->alergi_makanan ?? '-' }}"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Alergi Udara</label>
                        <input
                            type="text"
                            readonly
                            class="w-full bg-gray-100 border rounded p-2"
                            value="{{ $assessment->alergi_udara ?? '-' }}"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Alergi Obat</label>
                        <input
                            type="text"
                            readonly
                            class="w-full bg-gray-100 border rounded p-2"
                            value="{{ $assessment->alergi_obat ?? '-' }}"
                        >
                    </div>
                </div>

            </div>
        </div>

        {{-- ================= SOAP & DIAGNOSA ================= --}}
        <div>
            <h2 class="font-semibold mb-3">SOAP</h2>

            <div class="space-y-4">

            <div class="mb-4">
                <label class="block text-sm text-gray-600">SOAP - Subjektif</label>
                <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->soap_subjektif }}</textarea>            
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600">SOAP - Objektif</label>
                <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->soap_objektif }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600">SOAP - Assesmen</label>
                <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->soap_assesmen }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600">SOAP - Perencanaan</label>
                <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->soap_perencanaan }}</textarea>
            </div>
            
                <div>
            <h3 class="font-medium mb-2">Diagnosa</h3>

                <div class="space-y-3">
                    @forelse ($assessment->diagnoses as $diag)
                        <div class="grid grid-cols-12 gap-2 items-end">
                            {{-- DIAGNOSA --}}
                            <div class="col-span-8">
                                <label class="text-xs text-gray-600">Diagnosa</label>
                                <div class="w-full border rounded p-2 text-sm bg-gray-100">
                                    {{ $diag->diagnosa }}
                                </div>
                            </div>

                            {{-- KATEGORI --}}
                            <div class="col-span-3">
                                <label class="text-xs text-gray-600">Kategori</label>
                                <div class="w-full border rounded p-2 text-sm bg-gray-100 capitalize">
                                    {{ $diag->kategori_label }}
                                </div>
                            </div>

                            {{-- EMPTY COL (pengganti tombol hapus) --}}
                            <div class="col-span-1"></div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400 italic">
                            Tidak ada diagnosa
                        </div>
                    @endforelse
                </div>
            </div>
            </div>
        </div>

        {{-- ================= TINDAKAN & OBAT ================= --}}
        <!-- <h2 class="font-semibold mb-3">Tindakan</h2> -->

        <div class="mb-6">
            <h3 class="font-medium mb-2">Tindakan / Prosedur</h3>

            <div class="space-y-2">
                @forelse ($assessment->procedures as $proc)
                    <div class="grid grid-cols-12 gap-2 items-end">
                        {{-- TINDAKAN --}}
                        <div class="col-span-5">
                            <label class="text-xs text-gray-600">Tindakan</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100">
                                {{ $proc->tindakan ?? '-' }}
                            </div>
                        </div>

                        {{-- JUMLAH --}}
                        <div class="col-span-2">
                            <label class="text-xs text-gray-600">Jumlah</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100 text-center">
                                {{ $proc->jumlah ?? '-' }}
                            </div>
                        </div>

                        {{-- PEMBAYARAN --}}
                        <div class="col-span-3">
                            <label class="text-xs text-gray-600">Pembayaran</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100 capitalize">
                                {{ $proc->pembayaran ?? '-' }}
                            </div>
                        </div>

                        {{-- HARGA --}}
                        <div class="col-span-2">
                            <label class="text-xs text-gray-600">Harga</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100 text-right">
                                {{ $proc->harga ? number_format($proc->harga, 0, ',', '.') : '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-400 italic">
                        Tidak ada tindakan
                    </div>
                @endforelse
            </div>
        </div>

        {{-- OBAT --}}
        <div class="mb-6">
            <h3 class="font-medium mb-2">Obat</h3>

            <div class="space-y-2">
                @forelse ($assessment->medications as $med)
                    <div class="grid grid-cols-12 gap-2 items-end">
                        {{-- NAMA OBAT --}}
                        <div class="col-span-5">
                            <label class="text-xs text-gray-600">Nama Obat</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100">
                                {{ $med->nama_obat ?? '-' }}
                            </div>
                        </div>

                        {{-- JENIS --}}
                        <div class="col-span-2">
                            <label class="text-xs text-gray-600">Jenis</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100">
                                {{ $med->jenis_label ?? '-' }}
                            </div>
                        </div>

                        {{-- DOSIS --}}
                        <div class="col-span-2">
                            <label class="text-xs text-gray-600">Dosis</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100">
                                {{ $med->dosis ?? '-' }}
                            </div>
                        </div>

                        {{-- JUMLAH --}}
                        <div class="col-span-2">
                            <label class="text-xs text-gray-600">Jumlah</label>
                            <div class="w-full border rounded p-2 text-sm bg-gray-100 text-center">
                                {{ $med->jumlah ?? '-' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-400 italic">
                        Tidak ada obat
                    </div>
                @endforelse
            </div>
        </div>


        <!-- <div>
            <h2 class="font-semibold mb-3">Tindakan & Obat</h2>

            <h3 class="font-medium">Tindakan</h3>
            <ul class="list-disc ml-5 mb-4">
                @forelse($assessment->procedures as $proc)
                    <li>
                        {{ $proc->tindakan }} —
                        Jumlah: {{ $proc->jumlah ?? '-' }},
                        Pembayaran: {{ ucfirst($proc->pembayaran) }},
                        Harga: {{ $proc->harga ? number_format($proc->harga, 0, ',', '.') : '-' }}
                    </li>
                @empty
                    <li class="text-gray-400">Tidak ada tindakan</li>
                @endforelse
            </ul>

            <h3 class="font-medium">Obat</h3>
            <ul class="list-disc ml-5">
                @forelse($assessment->medications as $med)
                    <li>
                        {{ $med->nama_obat }} —
                        Dosis: {{ $med->dosis ?? '-' }},
                        Jumlah: {{ $med->jumlah ?? '-' }},
                        Jenis: {{ ucfirst(str_replace('_',' ',$med->jenis)) }}
                    </li>
                @empty
                    <li class="text-gray-400">Tidak ada obat</li>
                @endforelse
            </ul>
        </div> -->

        {{-- ================= LAIN-LAIN ================= --}}
        <div>
            <h2 class="font-semibold mb-3">Lain-lain</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Petugas</label>
                    <input readonly value="{{ $assessment->petugas->name ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Kategori Kunjungan</label>
                    <input readonly value="{{ $assessment->kategori_kunjungan ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Tindak Lanjut</label>
                    <input readonly value="{{ $assessment->tindak_lanjut ?? '-' }}" class="w-full bg-gray-100 border rounded p-2">
                </div>
                <div>
                    <label class="text-sm text-gray-600">Catatan</label>
                    <textarea readonly class="w-full bg-gray-100 border rounded p-2">{{ $assessment->catatan ?? '-' }}</textarea>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('assessments.history', $assessment->patient_id) }}"
               class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection
