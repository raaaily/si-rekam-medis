@extends('layouts.app')
@section('title', 'Riwayat Assessment Pasien')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-700">Riwayat Assessment</h2>
            <p class="text-sm text-gray-500">Pasien: <span class="font-semibold">{{ $patient->nama_lengkap }}</span></p>
        </div>
        <a href="{{ route('assessments.create', $patient->id) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">
            + Assessment Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Kunjungan</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Keluhan</th>
                    <th class="px-6 py-3 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->assessments as $assessment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">Kunjungan ke-{{ $assessment->kunjungan_ke }}</td>
                        <td class="px-6 py-3">{{ $assessment->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-3">{{ $assessment->keluhan ?? '-' }}</td>
                        <td class="px-6 py-3 text-center flex justify-center gap-2">
                            {{-- Tombol Lihat --}}
                            <a href="{{ route('assessments.show', $assessment->id) }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-xs border">
                                Lihat
                            </a>

                            {{-- Tombol Edit --}}
                            <a href="{{ route('assessments.edit', $assessment->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-xs">
                                Edit
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('assessments.destroy', $assessment->id) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus assessment ini? Data diagnosa, tindakan, dan obat juga ikut terhapus. Lanjutkan?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4 text-gray-500">Belum ada riwayat kunjungan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('assessments.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali ke daftar pasien</a>
    </div>
</div>
@endsection
