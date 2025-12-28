@extends('layouts.app')

@section('title', 'Daftar Assessment Pasien')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- 🔍 Header dan Form Pencarian --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">
            🩺 Daftar Assessment Pasien
        </h1>

        <form action="{{ route('assessments.index') }}" method="GET" class="flex items-center w-full sm:w-auto">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari nama atau NIK pasien..." 
                class="w-full sm:w-64 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
            >
            <button 
                type="submit" 
                class="ml-2 px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition"
            >
                Cari
            </button>
        </form>
    </div>

    {{-- 📋 Tabel Data Pasien --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-indigo-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No RM</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Pasien</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">NIK</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Umur</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Jenis Kelamin</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-800">{{ $patient->no_rm ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-800 font-medium">{{ $patient->nama_lengkap}}</td>
                        <td class="px-4 py-3 text-gray-800">{{ $patient->nik }}</td>
                        <td class="px-4 py-3 text-gray-800">
                            @php
                                $birth = $patient->tanggal_lahir ?? null;
                                echo $birth ? \Carbon\Carbon::parse($birth)->age . ' th' : '-';
                            @endphp
                        </td>
                        <td class="px-4 py-3 text-gray-800">{{ ucfirst($patient->jenis_kelamin) }}</td>

                        <td class="px-4 py-3 text-center space-x-2">
                            {{-- ➕ Tambah Assessment Baru --}}
                            <a href="{{ route('assessments.create', $patient->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700 transition">
                                ➕ Tambah
                            </a>

                            {{-- 📋 Lihat Riwayat --}}
                            <a href="{{ route('assessments.history', $patient->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700 transition">
                                📋 Riwayat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada data pasien ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 🔢 Pagination --}}
    <div class="mt-6">
        {{ $patients->links() }}
    </div>
</div>
@endsection
