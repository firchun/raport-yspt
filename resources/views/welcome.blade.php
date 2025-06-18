<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Santri Perbatasan Timur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo-yayasan.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logo-yayasan.png') }}" />
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">

    <!-- Logo -->
    <div class="mb-6">
        <img src="{{ asset('img/logo-yayasan.png') }}" alt="Logo" class="w-auto h-[100px]">
    </div>

    <!-- Card -->
    @if (!$santri)
        <div class="bg-red-500 p-8 rounded-2xl shadow-md text-center max-w-md">
            <div class="flex justify-center mb-4">
                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3m0 4h.01M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-2">Data Santri Tidak Ditemukan</h1>
            <p class="text-white mb-6">Harap melapor pada administrator jika data yang anda cari belum terdaftar
                atau tidak ditemukan pada halaman ini.</p>
        </div>
    @else
        <div class="bg-white p-8 rounded-xl shadow-md text-center w-full max-w-lg lg:max-w-4xl">
            <h3 class="text-xl font-semibold mb-4">Laporan Santri: {{ $santri->nama }}</h3>
            <!-- Konten tambahan disini -->
        </div>
    @endif

</body>

</html>
