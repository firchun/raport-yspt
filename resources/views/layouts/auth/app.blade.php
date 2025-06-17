<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Raport Pondok Pesantren Santri Perbatasan Timur</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Login ke sistem E-Raport Pondok Pesantren Santri Perbatasan Timur. Dikelola oleh Yayasan Santri Perbatasan Timur di Merauke, Papua Selatan.">
    <meta name="keywords"
        content="raport pondok pesantren santri perbatasan timur, yayasan santri perbatasan timur, pondok modern merauke, merauke, pondok papua selatan, pondok merauke, pesantren merauke, pondok pesantren papua, sistem raport digital">
    <meta name="author" content="Yayasan Santri Perbatasan Timur">

    <!-- Open Graph (untuk share di media sosial) -->
    <meta property="og:title" content="Login | E-Raport Pondok Pesantren Santri Perbatasan Timur">
    <meta property="og:description"
        content="Login ke sistem E-Raport Pondok Pesantren Santri Perbatasan Timur, Merauke - Papua Selatan.">
    <meta property="og:image" content="{{ asset('img/logo-yayasan.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logo-yayasan.png') }}" type="image/png">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center text-gray-900">
    <div class="w-full max-w-md">
        @yield('content')
    </div>

    <footer class="mt-6 text-center text-sm text-gray-400">
        <p>
            &copy; 2022–{{ date('Y') }} Yayasan Santri Perbatasan Timur – All Rights Reserved<br>
            ❤️ <a href="#" class="text-blue-500 hover:underline">BomiDev</a>
        </p>
    </footer>
</body>


</html>
