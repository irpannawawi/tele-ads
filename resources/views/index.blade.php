<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="monetag" content="c9a00fb38060b583580d7511e729c881">
    <title>Kejar Cuan Ads System</title>
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>


    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @if (env('APP_ENV') === 'production')
        <link rel="me" href="https://www.blogger.com/profile/10804049986906260085" />
        <meta name='google-adsense-platform-account' content='ca-host-pub-1556223355139109' />
        <meta name='google-adsense-platform-domain' content='blogspot.com' />
    @endif
</head>

<body>
    <!-- NOTIFIKASI INTERVAL RANDOM WAKTU  -->
    <div id="floating-notification"
        style="
    position: fixed;
    bottom: 10px; /* Posisikan 10px dari bawah layar */
    left: 50%; /* Posisikan di tengah layar secara horizontal */
    transform: translateX(-50%); /* Benar-benar memusatkan elemen secara horizontal */
    background-color: #333;
    color: white;
    padding: 11px 20px; /* Padding yang lebih seimbang */
    border-radius: 14px;
    text-align: center; /* Memastikan teks berada di tengah */
    box-shadow: 0 20px 6px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 1000;
    max-width: 280px; /* Menetapkan lebar maksimum */
    width: auto; /* Lebar elemen menyesuaikan dengan teks */">
    </div>


    <!-- Kontainer Utama -->
    <div class="wraper">
        <div class="container">
            <h1>Tonton Iklan dan Dapatkan Cuan Menarik Setiap Hari! 🆕</strong></h1>
            <div class="buttons">
                <button id="developer" onclick="window.location.href='https://t.me/cuanads'">Bukti Pembayaran</button>
            </div>

            <div class="user-info">
                <img id="user-photo" src="" alt="User Photo">
                <p id="user-name"></p>
            </div>

            <div class="stats">
                <p>Iklan yang Ditonton: <span id="watched-ads">0</span></p>
                <p>Cuan yang Kamu Peroleh: <b>Rp <span id="earned-points">0</span></b></p>

                <p>Minimal Penarikan: <b>Rp 3.000,-</b></p>
                <p>Total Penarikan Kamu: Rp <span id="total-withdrawn">0</span></p>
            </div>
            <div class="buttons">
                <x-btn-developer></x-btn-developer>
                <button id="watch-ad-btn" onclick="watchAd()">Mulai Tonton Iklan 🔥</button>
                {{-- <button id="auto-ad-btn" onclick="startAutoAds()">Tonton Iklan Otomatis</button>
                <button id="stop-auto-btn" onclick="stopAutoAds()">Stop Iklan Otomatis</button> --}}
                <button id="withdraw-btn" onclick="showWithdrawForm()">Tarik Dana</button>
                <button id="history-btn" onclick="showWithdrawHistory()">Riwayat Penarikan</button>
                <!-- Tombol Riwayat -->
                <x-ewallet />
            </div>
            <!-- Withdraw Section -->
            <div class="withdraw-section" id="withdraw-section">
                <h4 style="color: orange; margin-bottom: 15px;">Permintaan Penarikan</h4>
                <h5 style="color: orange; margin-bottom: 15px;">(Minimal Penarikan Rp.
                    {{ number_format(env('MIN_WITHDRAW_POINTS'), 0, ',', '.') }}) berlaku kelipatan Rp. 1.000</h5>

                <!-- Form Container -->

                <div class="form-container">
                    <!-- Input untuk jumlah poin -->
                    <input type="number" min="{{ env('MIN_WITHDRAW_POINTS') }}"
                         id="withdraw-amount"
                        placeholder="Masukkan nilai rupiahnya" required />
                    <!-- Pilihan metode pembayaran -->
                    <select id="payment-method">
                        <option value="Dana">Saldo Dana</option>
                        <option value="Ovo">Saldo OVO</option>
                        <!--<option value="Gopay">Saldo Gopay</option>-->
                    </select>
                </div>
                <!-- Input untuk nomor telepon di tengah -->
                <div class="form-container-phone">
                    <input type="number" id="withdraw-phone" placeholder="Masukkan Nomor Telepon" required/>
                </div>
                <!-- Tombol untuk withdraw dan kembali -->
                <div class="button-container">
                    <button class="blink-button" onclick="withdraw()">Tarik
                        Sekarang</button>
                    <button class="go-back-btn" onclick="goBack()">Kembali</button>
                </div>

            </div>
            {{-- riwayat withdraw --}}
            <div class="withdraw-history" id="withdraw-history">
                <h3>Riwayat Penarikan</h3>
                <ul id="list-withdraw-history"></ul>
                <button onclick="hideWithdrawHistory()">Kembali</button>
            </div>
        </div>
    </div>


    <!-- Tambahan informasi Harga 1 Poin -->
    <!-- Floating Notification -->
    <div id="floating-notification1">
        <p>1 Watch Ads = <span id="rate-point"></span> points
        <p>1 points = 1 Rupiah </p>
        <!--<p>1000 points = Rp 1.000 </p>-->

        </p>


    </div>



    <!---------------------------------------------------------------------------------------------------------------------------->
    <!---------------------------------------UNTUK SETTING SCRIPT IKLAN DISINI---------------------------------------------------->
    <!---------------------------------------------------------------------------------------------------------------------------->

    <!-- Pengaturan untuk Iklan Native Banner (Interstitial) -->


    <script src="{{ asset('js/tginit.js') }}"></script>

    @include('components.nativebanner')

</body>

<!-- JAVA SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
</script>
<script async>
    // Initialize Telegram WebApp
    const tga = window.Telegram.WebApp;

    // Expand WebApp to full height
    tga.expand();

    // Access user data
    const userData = tga.initDataUnsafe?.user;

    // Check if user data is available

    if (userData) {
        fetch("{{ route('user.get') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                phone: userData?.id,
                first_name: userData?.first_name,
                last_name: userData?.last_name,
                username: userData?.username,
                _token: '{{ csrf_token() }}'
            }),
        }).then(response => response.json()).then(data => {

            if (userData.photo_url) {
                userPhoto.src = userData.photo_url;
            } else {
                userPhoto.src = 'https://via.placeholder.com/100'; // Placeholder if no photo
            }

            // Display user's name
            const userName = document.getElementById('user-name');
            userName.textContent =
                `Hallo, ${userData.first_name} ${userData.last_name || ''} (@${userData.username || 'No username'})`;

            watchedAdsCount = parseInt(data.user.watched_ads_count);
            earnedPoints = parseFloat(data.user.earned_points);
            totalWithdrawn = parseFloat(data.user.total_withdraw);
            document.getElementById('watched-ads').textContent = watchedAdsCount;
            document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
            document.getElementById('total-withdrawn').textContent = totalWithdrawn.toFixed(0);
            WATCHED_ADS_TODAY = parseInt(data.watched_today)
            console.log(data)
            loadWithdrawHistory(data.all_withdrawals);
        });
        // Display user's phone number
        // Display user's photo
        const userPhoto = document.getElementById('user-photo');


    } else {
        document.querySelector('.user-info').innerHTML = '<p>Data pengguna tidak tersedia</p>';
        // window.location.href = 'https://t.me/cuanads';
    }
</script>
<script>
    // Pengaturan untuk poin per iklan
    const POINTS_PER_AD = {{ env('POINTS_PER_AD') }}; // Poin yang diperoleh untuk setiap iklan yang ditonton
    const POINTS_PER_AUTO_AD = {{ env('POINTS_PER_AUTO_AD') }}; // Poin yang diperoleh untuk setiap iklan otomatis
    const MIN_WITHDRAW_POINTS = {{ env('MIN_WITHDRAW_POINTS') }};
    const ADMIN_USER_ID = {{ env('ADMIN_USER_ID') }};
    const BOT_TOKEN = "{{ env('BOT_TOKEN') }}";
    const MAX_ADS_PER_DAY = {{ env('MAX_ADS_PER_DAY') }}; // Jumlah maksimum iklan per hari
    let WATCHED_ADS_TODAY = 0;


    // Fungsi untuk memperbarui data harian
    async function todayWatched() {
        return await fetch("{{ url('/limit_check') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                phone: userData?.id,
                _token: '{{ csrf_token() }}'
            }),
        }).then(response => response.json()).then(data => {
            if (data.success == false) {
                showError(data.message);
            } else {
                WATCHED_ADS_TODAY = data.history
            }

        })
    }
</script>

@include('components.function.withdraw')
@include('components.function.watch-ads')
@include('components.function.auto-ads')
@include('components.function.show-floating-notification')
@include('components.function.show-rate')
@include('components.function.send-telegram-message')
@include('components.function.show-withdraw-history')
@include('components.function.go-back')


</html>
