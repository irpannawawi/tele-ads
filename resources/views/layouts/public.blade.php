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
    <script type="speculationrules">
    {
      "prerender": [
        {
          "urls": ["{{ route('home')}}", "{{ route('withdrawals') }}", "{{ route('history') }}"]
        }
      ]
    }
  </script>
    <link rel="preload" href="{{ asset('assets/img/background.jpg') }}" as="image">
    <link rel="preload" href="{{ asset('assets/img/tiger.png') }}" as="image">

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
    </style>
</head>

<body>

    <div class="container bg-main vh-100 mb-3">
        @include('layouts.navbar')
        {{-- @yield('content') --}}

        @yield('content')

        @include('layouts.bottom-nav')
    </div>
    <script>
        function formatNumberShort(num) {
            if (num >= 1_000_000_000) {
                return (num / 1_000_000_000).toFixed(1).replace(/\.0$/, '') + 'B'; // Miliar
            } else if (num >= 1_000_000) {
                return (num / 1_000_000).toFixed(1).replace(/\.0$/, '') + 'M'; // Juta
            } else if (num >= 1_000) {
                return (num / 1_000).toFixed(1).replace(/\.0$/, '') + 'K'; // Ribu
            }
            return num.toString(); // Jika kurang dari 1000, tetap tampilkan angka aslinya
        }
    </script>

@include('components.function.nativebanner')
@include('components.function.watch-ads')
    <script>
        const tga = window.Telegram.WebApp;
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

            if (data.user == null) {
                console.log('user not found');
            }

            let userImage = document.getElementById("user-image");
            let userName = document.getElementById("user-name");
            let watchedAds = document.getElementById("watched-ads")
            let currentPoints = document.getElementById("earnings")
            let totalWithdrawn = document.getElementById("total-withdraw")
            WATCHED_ADS_TODAY = data.user.watched_ads_count;
            TASK_LIMIT = data.task_limit;
            // set value
            userImage.src = userData.photo_url;
            if (data.user.username == null) {
                userName.textContent = data.user.first_name + " " + data.user.last_name;
            } else {
                userName.textContent = data.user.username;
            }
                // Redirect to /home if route is /
                watchedAds.textContent = data.user.watched_ads_count;
                currentPoints.textContent = formatNumberShort(data.user.earned_points);
                totalWithdrawn.textContent = formatNumberShort(data.user.total_withdraw);

                let taskLimit = document.getElementById("task-limit");
                taskLimit.textContent = data.user.watched_ads_count + "/" + data.task_limit;




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
</body>

</html>
