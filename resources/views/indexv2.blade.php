@extends('layouts.public')

@section('content')
@include('components.richads')

    <div class="row mt-4 mb-1">
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
                    <p class="text-center mb-0">Cuan Tersedia</p>
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
    <div class="row mt-2">
        <div class="d-flex justify-content-center align-items-center px-1">
            <div class="p-1  w-100  ">
                <div class="card p-1 bg-transparent  border-0 text-white py-1">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/icon/money-bag.png') }}" alt="Sallary icon" class="img-fluid card-icon">
                        <span class="mx-2 fw-bold fs-2" id="total-income"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- progressbar --}}
    <div class="row mt-1">
        <div class="col">
            <div class="progress" role="progressbar" aria-label="Task progress" aria-valuenow="25" aria-valuemin="0"
                aria-valuemax="100">
                <div class="progress-bar progress-bar-striped progress-bar-animated overflow-visible" style="width: 0%"
                    id="task-progress-bar"></div>
            </div>
        </div>
    </div>
    {{-- button --}}
    <div class="row mt-1 pt-1">
        <div class="col text-center">
            <button id="btnCountdown" class="rounded-circle border-0 bg-dark-op75 text-white fw-bold d-none">
                <span class="fw-bold  position-absolute top-50  pt-5">
                    Anda dapat menonton iklan dalam
                    <span class="fw-bold" id="countdown"></span> detik
                </span>
                <img src="{{ asset('assets/img/icon_klik.png') }}" alt="Watch" class="img-fluid shadow-bottom">
            </button>
            <button id="btnWatch" class="rounded-circle border-0 bg-transparent">
                <img src="{{ asset('assets/img/icon_klik.png') }}" alt="Watch" class="img-fluid shadow-bottom">
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-2">
        <div class="p-1">
            <a href="https://t.me/bayarcuanads">

                <span class="fw-bold text-white badge bg-primary  rounded-pill p-4 py-3 fs-4">
                    Bukti Pembayaran
                </span>
            </a>
        </div>
    </div>
    

    <script>
        let btnWatch = document.getElementById('btnWatch')
        let countdown = document.getElementById('countdown')
        let btnCountdown = document.getElementById('btnCountdown')
        let interval;
        function showTimeout(time) {
            btnWatch.classList.add('d-none');
            btnCountdown.classList.remove('d-none');

            // update interval
            
            interval = setInterval(() => {
                time -= 1;
                countdown.innerHTML = time;
                if (time == 0) {
                    clearInterval(interval);
                    btnWatch.classList.remove('d-none');
                    btnCountdown.classList.add('d-none');
                }
            }, 1000);
        }

        function disableBtn() {
            btnWatch.disabled = true;
            showTimeout(20); // jumlah second
            btnWatch.disabled = false;
        }


        btnWatch.addEventListener('click', disableBtn)
    </script>
    @include('components.giga-ads')
@endsection
