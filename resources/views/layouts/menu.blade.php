<ul class="menu">
    {{-- 🌐 Menu umum --}}
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

    {{-- 👑 Menu Admin --}}
    @if(Auth::user()->role === 'admin')
        <li>
            <a href="#">Manajemen User</a>
            <ul>
                <li><a href="{{ route('users.index') }}">Daftar User</a></li>
                <li><a href="{{ route('users.create') }}">Tambah User</a></li>
            </ul>
        </li>

        <li>
            <a href="#">Pasien</a>
            <ul>
                <li><a href="{{ route('patients.index') }}">Daftar Pasien</a></li>
                <li><a href="{{ route('patients.create') }}">Tambah Pasien</a></li>
            </ul>
        </li>

        <li>
            <a href="#">Assessment</a>
            <ul>
                <li><a href="{{ route('assessments.index') }}">Daftar Assessment</a></li>
                {{-- Tambah assessment dilakukan dari riwayat pasien --}}
                <li><span class="text-gray-400">Tambah Assessment (via pasien)</span></li>
            </ul>
        </li>
    @endif

    {{-- 🩺 Menu Dokter --}}
    @if(Auth::user()->role === 'doctor')
        <li>
            <a href="#">Pasien</a>
            <ul>
                <li><a href="{{ route('patients.index') }}">Daftar Pasien</a></li>
            </ul>
        </li>

        <li>
            <a href="#">Assessment</a>
            <ul>
                <li><a href="{{ route('assessments.index') }}">Daftar Assessment</a></li>
                {{-- Tambah assessment dilakukan dari halaman riwayat pasien --}}
                <li><span class="text-gray-400">Tambah Assessment (via pasien)</span></li>
            </ul>
        </li>
    @endif

    {{-- 🚪 Logout --}}
    <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-left w-full px-2 py-1 hover:text-red-600">Logout</button>
        </form>
    </li>
</ul>
