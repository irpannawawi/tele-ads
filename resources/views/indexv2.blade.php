@extends('layouts.public')

@section('content')
    <div class="row mt-2 mb-4">
        <div class="d-flex justify-content-between px-1 card-row">
            <div class="p-1  w-100 card-bg-main ">
                <div class="card p-1 bg-transparent border-0 text-white">
                    <p class="text-center mb-0">Iklan Ditonton</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/icon/watch.png') }}" alt="Sallary icon" class="img-fluid card-icon">
                        <span class="fw-bold" id="watched-ads"></span>
                    </div>
                </div>
            </div>
            <div class="p-1 w-100 card-bg-main">

                <div class="card p-1 bg-transparent border-0 text-white">
                    <p class="text-center mb-0">Cuan Diperoleh</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/icon/salary.png') }}" alt="Sallary icon" class="img-fluid card-icon">
                        <span class="fw-bold text-center" id="earnings"></span>
                    </div>
                </div>
            </div>
            <div class="p-1  w-100 card-bg-main">

                <div class="card p-1 bg-transparent border-0 text-white">
                    <p class="text-center  mb-0">Total Withdraw</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/icon/transaction-history.png') }}" alt="Sallary icon"
                            class="img-fluid card-icon">
                        <span class="fw-bold text-center" id="total-withdraw"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- button --}}
    <div class="row mt-5 pt-4">
        <div class="col text-center">
            <button id="btnWatch" class="rounded-circle border-0 bg-transparent">
                <img src="{{ asset('assets/img/tiger.png') }}" alt="Watch" class="img-fluid shadow-bottom">
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between mt-3">
        <div class="p-1">
            <span class="fw-bold text-white badge bg-dark-op75 border border-dark  rounded-pill px-3"><img
                    src="{{ asset('assets/icon/task.png') }}" alt="" height="20"><span
                    id="task-limit"></span></span>
        </div>
        <div class="p-1">
            <a href="#">
                <span class="fw-bold text-white badge bg-dark-op75 border border-dark text-white rounded-pill px-3">
                    <img src="{{ asset('assets/icon/telegram.png') }}" alt="" height="20"> Saran
                </span>
            </a>
        </div>
    </div>
@endsection
