@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Pasien</h1>
        <a href="{{ route('patients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Pasien</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="px-4 py-3 border">No RM</th>
                    <th class="px-4 py-3 border">Nama Lengkap</th>
                    <th class="px-4 py-3 border">Jenis Kelamin</th>
                    <th class="px-4 py-3 border">Tanggal Lahir</th>
                    <th class="px-4 py-3 border">Umur</th>
                    <th class="px-4 py-3 border">Alamat</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border">{{ $patient->no_rm }}</td>
                        <td class="px-4 py-3 border">{{ $patient->nama_lengkap }}</td>
                        <td class="px-4 py-3 border">{{ $patient->jenis_kelamin }}</td>
                        <td class="px-4 py-3 border">{{ $patient->tanggal_lahir }}</td>
                        <td class="px-4 py-3 border">
                            {{ $patient->umur ? $patient->umur . ' th' : '-' }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ \Illuminate\Support\Str::limit($patient->alamat, 80) }}
                        </td>
                        <td class="px-4 py-3 border text-center space-x-1">
                            <a href="{{ route('patients.show', $patient) }}" class="inline-block bg-green-500 text-white px-2 py-1 rounded text-sm">Lihat</a>
                            <a href="{{ route('patients.edit', $patient) }}" class="inline-block bg-yellow-400 text-white px-2 py-1 rounded text-sm">Edit</a>
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pasien ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data pasien</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div>
@endsection
