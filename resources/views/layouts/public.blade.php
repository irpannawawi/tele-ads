<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script>
        window.addEventListener('load', function() {
            let initdata = Telegram.WebApp.initData;
            initdata.headerColor = '#00FF00';
        })
    </script>

    <link rel="preload" href="{{ asset('assets/img/background.jpg')}}" as="image">
    <link rel="preload" href="{{ asset('assets/img/tiger.png')}}" as="image">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .bg-dark-op50 {
            background-color: rgba(0, 0, 0, 0.418);
            /* Hitam dengan opacity 50% */
        }        
        .bg-dark-op75 {
            background-color: rgba(0, 0, 0, 0.75);
            /* Hitam dengan opacity 50% */
        }

        .bg-main {
            background-image: url("{{ asset('assets/img/background.jpg') }}");
            background-size: cover;
        }

        .card-bg-main {
            background: rgba(0, 0, 0, 0.76);
            border-radius: 20px;
        }

        .card-icon {
            width: 30px;
            height: 30px;
        }

        .card {
            font-size: 12px;
        }

        .card-row>div {
            margin-left: 1px;
            margin-right: 1px;
            height: 60px;
        }

        #bottomNavbar {
            background: rgba(0, 0, 0, 0.76)
        }

        #btnWatch {
            width: 300px;
            height: 300px;
            margin: 0px auto;
        }
        #btnWatch>img{
            /* border: 2px solid rgb(232 174 77); */
        }
        .menu-icon {
            padding: 0px;
            margin: 0px;
            font-size: 1.4rem;
            width: 35px;
            height: 35px;
        }

        .menu-label {
            padding: 0px;
            margin: 0px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.63)
        }

        .nav-item.active>i {
            font-size: 1.8rem;
        }
        .fs-knewave{
            font-family: 'Knewave', cursive;
        }
    </style>
</head>

<body>

    <div class="container bg-main vh-100">
        {{-- header --}}
        <div class="d-flex justify-content-start align-items-center p-1">
            <a href="">
                <div style="height: 35px"
                    class="profile  bg-dark-op50 text-white p-2  border border-1 border-success rounded-pill d-flex align-items-center justify-content-start">
                    <img class="rounded-circle me-2 float-start" src="https://placehold.co/28" alt="Placeholder Image">
                    <span class="float-start opacity-100">
                        @username
                    </span>
                </div>
            </a>
        </div>

        {{-- @yield('content') --}}
        <div class="row mt-2 mb-4">
            <div class="d-flex justify-content-between px-1 card-row">
                <div class="p-1  w-100 card-bg-main ">
                    <div class="card p-1 bg-transparent border-0 text-white">
                        <p class="text-center mb-0">Iklan Ditonton</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/icon/watch.png') }}" alt="Sallary icon"
                                class="img-fluid card-icon">
                            <span class="fw-bold">100</span>
                        </div>
                    </div>
                </div>
                <div class="p-1 w-100 card-bg-main">

                    <div class="card p-1 bg-transparent border-0 text-white">
                        <p class="text-center mb-0">Cuan Diperoleh</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/icon/salary.png') }}" alt="Sallary icon" class="img-fluid card-icon">
                            <span class="fw-bold text-center">
                                50K</span>
                            </div>
                    </div>
                </div>
                <div class="p-1  w-100 card-bg-main">

                    <div class="card p-1 bg-transparent border-0 text-white">
                        <p class="text-center  mb-0">Total Withdraw</p>
                        <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/icon/transaction-history.png') }}" alt="Sallary icon"
                                class="img-fluid card-icon">
                                <span class="fw-bold text-center">
                                    50K</span>
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
                <span class="fw-bold text-white badge bg-dark-op75 border border-dark  rounded-pill px-3"><img src="{{ asset('assets/icon/task.png') }}" alt="" height="20"> 1/200</span>
            </div>
            <div class="p-1">
                <span class="fw-bold text-white badge bg-dark-op75 border border-dark  rounded-pill px-3"><img src="{{ asset('assets/icon/telegram.png') }}" alt="" height="20"> Saran</span>
            </div>
            
        </div>

        <!-- Bottom Navbar -->
        <nav id="bottomNavbar"
            class="navbar navbar-dark navbar-expand rounded-pill d-md-none d-lg-none d-xl-none d-xxl-none fixed-bottom mb-2 shadow mx-2">
            <ul class="navbar-nav nav-justified w-100">
                <li class="nav-item p-0 active">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/house.png') }}" alt="">
                    <a href="#" class="nav-link text-center menu-label">Home</a>
                </li>
                <li class="nav-item p-0">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/salary.png') }}" alt="">

                    <a href="#" class="nav-link text-center menu-label">Tarik Dana</a>
                </li>
                <li class="nav-item p-0">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/transaction-history.png') }}"
                        alt="">
                    <a href="#" class="nav-link text-center menu-label">Riwayat</a>
                </li>
                <li class="nav-item p-0">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/stack-of-books.png') }}" alt="">
                    <a href="#" class="nav-link text-center menu-label">Tutorial</a>
                </li>
            </ul>
        </nav>
    </div>




</body>

</html>
