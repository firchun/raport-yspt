@extends('layouts.auth.app')

@section('content')
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('img/logo-yayasan.png') }}" alt="Logo" class="w-auto h-20">
        </div>
        <h2 class="text-2xl font-semibold text-center mb-1">E-raport </h2>
        <h3 class="text-lg font-semibold text-center mb-1">Pondok Pesantren Santri Perbatasan Timur</h3>
        <p class="text-gray-500 text-center mb-6"> اَلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَا تُهُ</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" required autofocus placeholder="Enter your email"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center space-x-2 text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="form-checkbox text-blue-600">
                    <span>Remember me</span>
                </label>
                {{-- <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password</a> --}}
            </div>

            <button type="submit" class="w-full bg-black text-white py-2 rounded-md hover:bg-gray-800 transition">Sign
                in</button>





        </form>
    </div>
@endsection
