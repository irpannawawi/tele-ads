<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuan Ads Rewards</title>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    
    <script>
        // setup 
        const tga = window.Telegram.WebApp;
        tga.setBottomBarColor('#000000');
        tga.setHeaderColor('#000000');
        tga.colorScheme='dark';
    </script>
    <script>
        window.addEventListener('load', function() {
            let initdata = Telegram.WebApp.initData;
            initdata.headerColor = '#00FF00';
        })
    </script>
    {{-- @include('components.richads') --}}
    
    
    <link rel="preload" href="{{ asset('assets/img/background.jpg') }}" as="image">
    <link rel="preload" href="{{ asset('assets/img/icon_klik.png') }}" as="image">
    <link rel="preload" href="{{ asset('assets/icon/watch.png') }}" as="image">
    <link rel="preload" href="{{ asset('assets/icon/salary.png') }}" as="image">
    <link rel="preload" href="{{ asset('assets/icon/transaction-history.png') }}" as="image">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
   @stack('css')
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
            border-radius: 10px;
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
            background: rgba(0, 0, 0, 0.76);
            z-index: 1;
        }

        #btnWatch, #btnCountdown {
            width: 300px;
            height: 300px;
            margin: 0px auto;
        }
        #btnCountdown >img{
            opacity: 0.4;
        }
        #btnCountdown>span{
            left: 10%;
        }
        #btnWatch>img:active {
            transform: translateY(6px);
        }

        #btnWatch>img {
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

        .fs-knewave {
            font-family: 'Knewave', cursive;
        }

        .progress {
            height: 30px;
            background-color: rgba(0, 0, 0, 0.438);
            margin: 0px 30px 0px 30px;
        }
        .progress-bar {
            background-color: #b38807;
            /* background-color: #206d01; */
        }
    </style>
</head>

<body>

    <div class="container bg-main vh-100 mb-3">
        @include('layouts.navbar')
        {{-- @yield('content') --}}

        @yield('content')

        @include('layouts.bottom-nav')
        @include('components.tutorial')
    </div>
    <script>
        function formatNumberShort(num) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0
            }).format(num);
        }
    </script>

    @include('components.function.nativebanner')
    @include('components.function.watch-ads')
    <script>
        
        let WATCHED_ADS_TODAY;
        let TASK_LIMIT;
        // Expand WebApp to full height
        tga.expand();
        const userData = tga.initDataUnsafe?.user;

        // Access user data
        fetch("{{ url('/') }}" + "/api/user/" + userData.id, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Access-Control-Allow-Origin": "*",
            }
        }).then(response => response.json()).then(data => {

            if (data.success == false) {
                console.log('user not found');
                createUser(userData.id, userData.first_name, userData.last_name, userData.username);
                return;
            }

            let userImage = document.getElementById("user-image");
            let userName = document.getElementById("user-name");
            let watchedAds = document.getElementById("watched-ads")
            let currentPoints = document.getElementById("earnings")
            let totalWithdrawn = document.getElementById("total-withdraw")
            let totalIncome = document.getElementById("total-income")
            WATCHED_ADS_TODAY = data.user.watched_ads_count;
            TASK_LIMIT = data.task_limit;
        

            // set value
            userImage.src = userData.photo_url;
            if (data.user.username == null) {
                userName.textContent = data.user.first_name.toUpperCase() + " " + data.user.last_name.toUpperCase();
            } else {
                userName.textContent = data.user.username.toUpperCase();
            }

            if(data.user.status =='suspended'){
                userName.appendChild(document.createTextNode(' \n(suspended)'));
                userName.style.color = 'red';
                userName.style.fontSize = '10px';
                tga.showAlert("Your account has been suspended. Please contact support.");

            }
            // Redirect to /home if route is /
            watchedAds.textContent = data.user.watched_ads_count;
            currentPoints.textContent = formatNumberShort(data.user.earned_points);
            totalWithdrawn.textContent = formatNumberShort(data.user.total_withdraw);
            totalIncome.textContent = formatNumberShort(data.user.total_withdraw + data.user.earned_points);


            let taskLimitBar = document.getElementById("task-progress-bar");
            taskLimitBar.style.width = (data.user.watched_ads_count / data.task_limit) * 100 + "%";
            taskLimitBar.textContent = data.user.watched_ads_count + "/" + data.task_limit + " Task";




            // ads click
            btnWatch = document.getElementById("btnWatch");
            btnWatch.addEventListener("click", () => {
                watchAd();
            });

        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function createUser(id, first_name, last_name, username) {
            fetch("{{ route('createUser') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: id,
                    first_name: first_name,
                    last_name: last_name,
                    username: username,
                    _token: '{{ csrf_token() }}'
                }),
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
        }

        function showError(message) {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonText: 'Tutup'
            })
        }

        function showSuccess(message) {
            Swal.fire({
                title: 'Berhasil!',
                text: message,
                icon: 'success',
                confirmButtonText: 'Tutup'
            })
        }
        @if (session('success'))
            showSuccess("{{ session('success') }}");
        @endif

        @if (session('error'))
            showError("{{ session('error') }}");
        @endif
    </script>

    @stack('js')
</body>

</html>
