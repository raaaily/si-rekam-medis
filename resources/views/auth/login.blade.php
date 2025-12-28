<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center h-screen">

    <!-- BAGIAN LOGO + TULISAN -->
    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('logofk.png') }}" alt="Logo FK UNISA" class="w-24 mb-3">
        <h1 class="text-xl font-bold text-gray-700 text-center leading-tight">
            Selamat Datang di <br>
            Rekam Medis Elektronik <br>
            Fakultas Kedokteran UNISA Yogyakarta
        </h1>
    </div>

    <!-- BOX LOGIN -->
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Login</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-600 mb-1">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
