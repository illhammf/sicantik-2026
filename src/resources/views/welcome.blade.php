@extends('layouts.front')

@section('content')
    @include('front._navbar')

    @if (session('success'))
        <div class="flash-message">
            {{ session('success') }}
        </div>
    @endif

    @include('front._hero')
    @include('front._stats')
    @include('front._kategori')
    @include('front._menu')
    @include('front._pesanan')
    @include('front._alur')
    @include('front._faq')
    @include('front._ulasan')
    @include('front._kontak')
    @include('front._footer')

    @stack('scripts')
@endsection
