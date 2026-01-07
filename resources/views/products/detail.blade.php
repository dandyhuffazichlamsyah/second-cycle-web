@extends('layouts.app')

@section('title', 'Detail Motor')

@section('content')
    <header class="site-header section-padding d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-12">
                    <h1>
                        <span class="d-block text-primary">Cari MOKAS</span>
                        <span class="d-block text-dark">SC IN AJA</span>
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <section class="product-detail section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="product-thumb">
                        <img src="{{ asset('assets/images/product/gradebodyaerox.png') }}" class="img-fluid product-image" alt="">
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="product-info d-flex">
                        <div>
                            <h2 class="product-title mb-0">Aerox 2023</h2>
                            <p class="product-p" style="font-size: 24px;">155CC</p>
                        </div>
                        <big class="product-price text-muted ms-auto mt-auto mb-5">RP. 27.955.000</big>
                    </div>

                    <div class="product-description">
                         <a href="#" class="product-additional-link" data-bs-toggle="modal" data-bs-target="#lokasi-modal"><b>Lokasi SC Dealership>>></b></a>
                    </div>
                    
                    <div class="product-cart-thumb row">
                        <div class="col-lg-6 col-12">
                            <select class="form-select cart-form-select" id="inputGroupSelect01">
                                <option selected>ABS-YConnect</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                            <button type="submit" class="btn custom-btn cart-btn" data-bs-toggle="modal" data-bs-target="#cart-modal">Konfirmasi Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection