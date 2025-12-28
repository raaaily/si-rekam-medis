@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Tambah Pasien Baru</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block font-medium">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border rounded p-2" required>

                <label class="block mt-3">Nomor Asuransi</label>
                <input type="text" name="no_asuransi" value="{{ old('no_asuransi') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Nomor RM</label>
                <input type="text" name="no_rm" value="{{ $newRm }}" readonly class="w-full border rounded p-2 bg-gray-100 text-gray-600">

                <!-- <label class="block mt-3">Family Folder</label>
                <input type="text" name="family_folder" value="{{ old('family_folder') }}" class="w-full border rounded p-2"> -->

                <label class="block mt-3 font-medium">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border rounded p-2" required>

                <label class="block mt-3">Kepala Keluarga</label>
                <input type="text" name="kepala_keluarga" value="{{ old('kepala_keluarga') }}" class="w-full border rounded p-2">

                <label class="block mt-3">No KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border rounded p-2">
                    <option value="">-- pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>

                <label class="block mt-3">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Alamat</label>
                <textarea name="alamat" class="w-full border rounded p-2" rows="4">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="block">RT</label>
                <input type="text" name="rt" value="{{ old('rt') }}" class="w-full border rounded p-2">

                <label class="block mt-3">RW</label>
                <input type="text" name="rw" value="{{ old('rw') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Kabupaten</label>
                <input type="text" name="kabupaten" value="{{ old('kabupaten') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Desa</label>
                <input type="text" name="desa" value="{{ old('desa') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Dusun</label>
                <input type="text" name="dusun" value="{{ old('dusun') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Agama</label>
                <select name="agama" class="w-full border rounded p-2">
                    <option value="">-- pilih --</option>
                    <option value="Islam" {{ old('agama')=='Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama')=='Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama')=='Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama')=='Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama')=='Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ old('agama')=='Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>

                <label class="block mt-3">Hubungan Dalam Keluarga</label>
                <input type="text" name="hubungan_dalam_keluarga" value="{{ old('hubungan_dalam_keluarga') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Pendidikan</label>
                <input type="text" name="pendidikan" value="{{ old('pendidikan') }}" class="w-full border rounded p-2">

                <label class="block mt-3">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border rounded p-2">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('patients.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
