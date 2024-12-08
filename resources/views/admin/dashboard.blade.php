@extends('layouts.backend.admin')

@section('content')
    <div class="title pb-20">
        <h2 class="h3 mb-0">Dashboard Overview</h2>
    </div>
    <div class="my-3">
        <div class="text-center mb-4">
            <div class="mb-3">
                <img src="{{ asset('/img') }}/logo-pesantren.png" alt="Logo Kanan" class="logo mx-2" style="width: 100px;">
                <img src="{{ asset('/img') }}/logo-yayasan.png" alt="Logo Kanan" class="logo mx-2" style="width: 100px;">
            </div>
            <hr>
            <h2 class="mb-2"> اَلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَا تُهُ</h2>
            <p>Selamat datang di website</p>
            <h5><span class="p-2 bg-warning" style="border-radius:10px;">Raport Pesantren Yayasan Santri Perbatasan
                    Timur</span></h5>
        </div>
        <hr>
    </div>
    <div class="row justify-content-center">
        @include('admin.dashboard_component.card1', [
            'count' => $users,
            'title' => 'Users',
            'subtitle' => 'Total users',
            'color' => 'primary',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $pengasuh,
            'title' => 'Musyrif/ah',
            'subtitle' => 'Total Musyrif/ah',
            'color' => 'warning',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $santri,
            'title' => 'Santri',
            'subtitle' => 'Total Santri',
            'color' => 'success',
            'icon' => 'user',
        ])

    </div>
@endsection
