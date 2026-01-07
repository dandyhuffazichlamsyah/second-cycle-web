@extends('layouts.main')

@section('title', 'Selamat Datang di SecondCycle')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white mb-4">Selamat Datang di SecondCycle</h1>
                <p class="lead text-white mb-4">Platform jual beli motor bekas berkualitas dengan proses inspeksi ketat dan transparan.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
