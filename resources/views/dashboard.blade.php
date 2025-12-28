@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 mb-6">
    <h1 class="text-3xl font-bold">Dashboard</h1>
    <span class="text-gray-600 text-sm">
        Halo, <b>{{ auth()->user()->name }}</b> ({{ auth()->user()->role }})
    </span>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Total Pasien</p>
        <p class="text-3xl font-bold text-blue-600">{{ $totalPasien }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Rekam Medis Hari Ini</p>
        <p class="text-3xl font-bold text-green-600">{{ $rekamMedisHariIni }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Dokter Aktif</p>
        <p class="text-3xl font-bold text-purple-600">{{ $dokterAktif }}</p>
    </div>

</div>

{{-- ================= GRAFIK ================= --}}
<div class="bg-white p-6 rounded-lg shadow mb-8">
    <h2 class="text-xl font-semibold mb-4">
        Jumlah Asesmen 12 Bulan Terakhir
    </h2>

    <div class="w-full" style="height:320px">
        <canvas id="assessmentChart"></canvas>
    </div>
</div>

{{-- ================= PASIEN TERBARU ================= --}}
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Pasien Terbaru</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Umur</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">Terakhir Kontrol</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($latestPatients as $patient)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">
                        {{ $patient->nama_lengkap }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} th
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $patient->jenis_kelamin }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $patient->updated_at->format('d-m-Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">
                        Belum ada data pasien
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= CHART SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // DEBUG (boleh dihapus kalau sudah OK)
    console.log('Months:', {!! json_encode($assessmentMonths) !!});
    console.log('Counts:', {!! json_encode($assessmentCounts) !!});

    const ctx = document
        .getElementById('assessmentChart')
        .getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($assessmentMonths) !!},
            datasets: [{
                label: 'Jumlah Asesmen',
                data: {!! json_encode($assessmentCounts) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

});
</script>

@endsection
