<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Rekam Medis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white flex flex-col transition-all duration-300 shadow-lg" id="sidebar">
        <!-- Header -->
        <div class="p-6 text-center font-bold text-2xl border-b border-blue-500 tracking-wide">
            Rekam Medis
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-4">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="block py-2 px-4 rounded {{ request()->is('dashboard') ? 'bg-blue-900' : 'hover:bg-blue-500' }}">
                Dashboard
            </a>

            <!-- Menu Admin -->
            @if(Auth::user()->role === 'admin')
                <!-- Manajemen User -->
                <div class="space-y-1">
                    <span class="block py-2 px-4 font-semibold uppercase text-sm text-blue-200">Manajemen User</span>
                    <a href="{{ route('users.create') }}" 
                       class="block py-2 px-6 rounded hover:bg-blue-500 {{ request()->is('users/create') ? 'bg-blue-900' : '' }}">
                        ➕ Tambah User
                    </a>
                </div>

                <!-- Pasien -->
                <div class="space-y-1">
                    <span class="block py-2 px-4 font-semibold uppercase text-sm text-blue-200">Pasien</span>
                    <a href="{{ route('patients.index') }}" 
                       class="block py-2 px-6 rounded hover:bg-blue-500 {{ request()->is('patients') ? 'bg-blue-900' : '' }}">
                        Daftar Pasien
                    </a>
                    <a href="{{ route('patients.create') }}" 
                       class="block py-2 px-6 rounded hover:bg-blue-500 {{ request()->is('patients/create') ? 'bg-blue-900' : '' }}">
                        ➕ Tambah Pasien
                    </a>
                </div>

                <!-- Assessment -->
                <div class="space-y-1">
                    <span class="block py-2 px-4 font-semibold uppercase text-sm text-blue-200">Asesmen</span>
                    <a href="{{ route('assessments.index') }}" 
                       class="block py-2 px-6 rounded hover:bg-blue-500 {{ request()->is('assessments') ? 'bg-blue-900' : '' }}">
                        Daftar Asesmen
                    </a>
                </div>
            @endif

            <!-- Menu Dokter -->
            @if(Auth::user()->role === 'doctor')
                <!-- Pasien -->
                <div class="space-y-1">
                    <span class="block py-2 px-4 font-semibold uppercase text-sm text-blue-200">Pasien</span>
                    <a href="{{ route('patients.index') }}" 
                       class="block py-2 px-6 rounded hover:bg-blue-500 {{ request()->is('patients') ? 'bg-blue-900' : '' }}">
                        Daftar Pasien
                    </a>
                </div>

                <!-- Assessment -->
                <div class="space-y-1">
                    <span class="block py-2 px-4 font-semibold uppercase text-sm text-blue-200">Asesmen</span>
                    <a href="{{ route('assessments.index') }}" 
                        class="block py-2 px-6 rounded hover:bg-blue-500 {{ request()->is('assessments') ? 'bg-blue-900' : '' }}">
                        Daftar Asesmen
                    </a>

                </div>
            @endif
        </nav>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="p-4 border-t border-blue-500">
            @csrf
            <button type="submit" 
                class="w-full bg-red-500 hover:bg-red-600 py-2 rounded font-semibold transition">
                Logout
            </button>
        </form>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 p-6 overflow-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
