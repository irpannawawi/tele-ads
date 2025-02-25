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
            <button id="auto-ad-btn" onclick="startAutoAds()">Tonton Iklan Otomatis</button>
            <button id="stop-auto-btn" onclick="stopAutoAds()">Stop Iklan Otomatis</button>
            <button id="withdraw-btn" onclick="showWithdrawForm()">Tarik Dana</button>
            <button id="history-btn" onclick="showWithdrawHistory()">Riwayat Penarikan</button> <!-- Tombol Riwayat -->
            <x-ewallet />
        </div>
        <!-- Withdraw Section -->
        <div class="withdraw-section" id="withdraw-section">
            <h4 style="color: orange; margin-bottom: 15px;">Permintaan Penarikan</h4>
            <h5 style="color: orange; margin-bottom: 15px;">(Masukan Kelipatan 3000)</h5>

            <!-- Form Container -->
            <div class="form-container">
                <!-- Input untuk jumlah poin -->
                <input type="number" id="withdraw-amount" placeholder="Masukkan nilai rupiahnya" />
                <!-- Pilihan metode pembayaran -->
                <select id="payment-method">
                    <option value="Dana">Saldo Dana</option>
                    <option value="Ovo">Saldo OVO</option>
                    <!--<option value="Gopay">Saldo Gopay</option>-->
                </select>
            </div>
            <!-- Input untuk nomor telepon di tengah -->
            <div class="form-container-phone">
                <input type="number" id="withdraw-phone" placeholder="Masukkan Nomor Telepon" />
            </div>
            <!-- Tombol untuk withdraw dan kembali -->
            <div class="button-container">
                <button class="blink-button" onclick="withdrawPoints()">Tarik Sekarang</button>
                <button class="go-back-btn" onclick="goBack()">Kembali</button>
            </div>
        </div>
        <!-- Withdraw Status -->
        <div id="withdraw-status"></div>
        <div id="withdraw-status-failed">Penarikan Gagal! Nilai atau Nomor Telepon Tidak Valid.</div>
        <div id="withdraw-status-success">Penarikan Berhasil!</div>
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

    sc

</body>

<!-- JAVA SCRIPT -->
<script>
    // Pengaturan untuk poin per iklan
    const POINTS_PER_AD = {{ env('POINTS_PER_AD') }}; // Poin yang diperoleh untuk setiap iklan yang ditonton
    const POINTS_PER_AUTO_AD = {{ env('POINTS_PER_AUTO_AD') }}; // Poin yang diperoleh untuk setiap iklan otomatis
    const MIN_WITHDRAW_POINTS = {{ env('MIN_WITHDRAW_POINTS') }};
    const ADMIN_USER_ID = {{ env('ADMIN_USER_ID') }};
    const BOT_TOKEN = "{{ env('BOT_TOKEN') }}";

    let watchedAdsCount = 0;
    let earnedPoints = parseFloat(localStorage.getItem('earnedPoints')) || 0;
    let totalWithdrawn = parseFloat(localStorage.getItem('totalWithdrawn')) || 0;

    // Load data dari cloudStorage
    window.onload = function() {
        document.getElementById('watched-ads').textContent = watchedAdsCount;
        document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
        document.getElementById('total-withdrawn').textContent = totalWithdrawn.toFixed(0);
        document.getElementById('ads-progress').textContent = `${Math.min(watchedAdsCount * 10, 100)}%`;
    };

    // Fungsi untuk menampilkan informasi rate point
    function showRatePointInfo() {
        const notification = document.getElementById('floating-notification1');
        const ratePoint = document.getElementById('rate-point');
        ratePoint.textContent = POINTS_PER_AD.toFixed(0);
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.bottom = '50px';
            setTimeout(() => {
                notification.style.display = 'none';
                notification.style.bottom = '-50px';
            }, 5000);
        }, 100);
    }

    // Fungsi untuk menonton iklan manual
    function watchAd() {
        if (typeof show_8633423 === 'function') {
            show_8633423().then(() => {
                watchedAdsCount++;
                earnedPoints += POINTS_PER_AD; // Tambahkan poin manual
                localStorage.setItem('watchedAdsCount', watchedAdsCount);
                localStorage.setItem('earnedPoints', earnedPoints);

                document.getElementById('watched-ads').textContent = watchedAdsCount;
                document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
                document.getElementById('total-withdrawn').textContent = totalWithdrawn.toFixed(0);
                document.getElementById('ads-progress').textContent = Math.round((watchedAdsCount / 1000) *
                    100) + '%';
            });
        }

    }

    // Fungsi untuk menonton iklan otomatis
    let autoAdsInterval;
    let isAdPlaying = false;
    let lastInterval = 0;

    // Fungsi untuk menghasilkan interval waktu acak (dalam milidetik)
    function getRandomInterval(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // Fungsi untuk menampilkan notifikasi mengambang
    function showFloatingNotification(message) {
        const notification = document.getElementById('floating-notification');
        notification.textContent = message;
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.bottom = '177px';
            setTimeout(() => {
                notification.style.display = 'none';
                notification.style.bottom = '-50px';
            }, 5000);
        }, 100);
    }

    // Fungsi untuk reset semua data di localStorage
    // function resetLocalStorage() {
    //     localStorage.clear();
    //     // After clearing the localStorage, refresh the page to update the UI with the reset values
    //     window.location.reload();
    // }

    // Contoh cara untuk memanggil fungsi resetLocalStorage
    // Anda bisa menambahkan tombol atau panggil fungsi ini sesuai kebutuhan
    // Misalnya, jika ingin menambahkan tombol untuk reset:
    const resetButton = document.createElement("button");
    resetButton.textContent = "Reset Data";
    resetButton.style.backgroundColor = "#FF6347"; // Optional: styling for reset button
    resetButton.style.color = "#fff";
    resetButton.style.padding = "10px 20px";
    resetButton.style.border = "none";
    resetButton.style.borderRadius = "5px";
    resetButton.style.cursor = "pointer";
    resetButton.onclick = resetLocalStorage;
    document.body.appendChild(resetButton);

    function resetLocalStorage() {
        // Clear all localStorage data
        localStorage.clear();
        // Reset any displayed values to default
        watchedAdsCount = 0;
        earnedPoints = 0;
        totalWithdrawn = 0;

        document.getElementById('watched-ads').textContent = watchedAdsCount;
        document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
        document.getElementById('total-withdrawn').textContent = totalWithdrawn.toFixed(0);
        // document.getElementById('ads-progress').textContent = '0%';

        showFloatingNotification("Data has been reset!");
    }

    function startAutoAds() {
        function runAd() {
            if (typeof show_8633423 === 'function' && !isAdPlaying) {
                isAdPlaying = true; // Tandai bahwa iklan sedang berjalan
                show_8633423()
                    .then(() => {
                        watchedAdsCount++;
                        earnedPoints += POINTS_PER_AUTO_AD; // Tambahkan poin otomatis

                        try {
                            localStorage.setItem('watchedAdsCount', watchedAdsCount);
                            localStorage.setItem('earnedPoints', earnedPoints);
                        } catch (e) {
                            console.error('Error saving to localStorage:', e);
                        }

                        document.getElementById('watched-ads').textContent = watchedAdsCount;
                        document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
                        document.getElementById('ads-progress').textContent = Math.round((watchedAdsCount / 1000) *
                            100) + '%';

                        isAdPlaying = false;

                        lastInterval = getRandomInterval(2700, 4300);
                        autoAdsInterval = setTimeout(runAd, lastInterval);
                    })
                    .catch((err) => {
                        console.error('Error playing ad:', err);
                        isAdPlaying = false;

                        showFloatingNotification(` ${lastInterval} ms`);

                        lastInterval = getRandomInterval(2700, 4300);
                        autoAdsInterval = setTimeout(runAd, lastInterval);
                    });
            }
        }

        lastInterval = getRandomInterval(2700, 4300);
        runAd();

        document.getElementById('stop-auto-btn').style.display = 'inline-block';
        document.getElementById('auto-ad-btn').style.display = 'none';
    }

    function stopAutoAds() {
        clearTimeout(autoAdsInterval);
        document.getElementById('auto-ad-btn').style.display = 'inline-block';
        document.getElementById('stop-auto-btn').style.display = 'none';
    }

    // Fungsi untuk menampilkan formulir penarikan
    function showWithdrawForm() {
        document.getElementById('withdraw-section').style.display = 'block';
    }

    // Fungsi untuk melakukan penarikan
    function withdrawPoints() {
        let withdrawAmount = document.getElementById('withdraw-amount').value;
        let paymentMethod = document.getElementById('payment-method').value;
        let phone = document.getElementById('withdraw-phone').value;

        if (withdrawAmount < MIN_WITHDRAW_POINTS) {
            showFloatingNotification('Minimal withdraw: ' + MIN_WITHDRAW_POINTS + ' rupiah');
            return;
        }

        if (withdrawAmount > earnedPoints) {
            showFloatingNotification('Not enough points');
            return;
        }

        if (!phone) {
            showFloatingNotification('Please enter your phone number');
            return;
        }

        earnedPoints -= withdrawAmount;
        totalWithdrawn += parseFloat(withdrawAmount);
        localStorage.setItem('earnedPoints', earnedPoints);
        localStorage.setItem('totalWithdrawn', totalWithdrawn);

        // Menyimpan data penarikan ke dalam riwayat
        const withdrawalHistory = JSON.parse(localStorage.getItem('withdrawalHistory')) || [];
        const newEntry = {
            amount: withdrawAmount,
            method: paymentMethod,
            phone: phone,
            date: new Date().toLocaleString()
        };
        withdrawalHistory.push(newEntry);
        localStorage.setItem('withdrawalHistory', JSON.stringify(withdrawalHistory));



        // Kirim pesan ke Telegram Bot
        sendTelegramMessage(
            `New withdrawal request:\n\nUser: @${user.username}\nAmount: ${withdrawAmount} Rupiah\nMethod:${paymentMethod}\nPhone: ${phone}\nDate: ${new Date().toLocaleString()}\nRemaining Points: ${earnedPoints}`
            );

        showSuccessNotification();
        document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
        document.getElementById('total-withdrawn').textContent = totalWithdrawn.toFixed(0);
        document.getElementById('withdraw-btn').textContent = "Withdraw Success!";
        setTimeout(() => {
            document.getElementById('withdraw-btn').textContent = "Withdraw";
        }, 3000);

        goBack();
    }

    // Fungsi untuk menampilkan notifikasi sukses
    function showSuccessNotification() {
        const successMessage = document.getElementById('withdraw-status-success');
        successMessage.style.display = 'block';

        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 3000);
    }
    // Batasi jumlah iklan harian
    const MAX_ADS_PER_DAY = {{ env('MAX_ADS_PER_DAY') }}; // Jumlah maksimum iklan per hari

    // Ambil data tanggal terakhir dan jumlah iklan harian dari localStorage
    let lastWatchedDate = localStorage.getItem('lastWatchedDate') || '';
    let dailyWatchedAdsCount = parseInt(localStorage.getItem('dailyWatchedAdsCount')) || 0;

    // Fungsi untuk memperbarui data harian
    function updateDailyAdCount() {
        const today = new Date().toLocaleDateString();

        if (today !== lastWatchedDate) {
            // Jika hari baru, reset hitungan
            lastWatchedDate = today;
            dailyWatchedAdsCount = 0;
            localStorage.setItem('lastWatchedDate', lastWatchedDate);
            localStorage.setItem('dailyWatchedAdsCount', dailyWatchedAdsCount);
        }
    }

    // Fungsi untuk menonton iklan manual (dengan pembatasan harian)
    function watchAd() {
        updateDailyAdCount();

        if (dailyWatchedAdsCount >= MAX_ADS_PER_DAY) {
            showFloatingNotification('Batas harian menonton iklan tercapai. Silahkan kembali lagi besok ya kak 🙏');
            return;
        }

        if (typeof show_8633423 === 'function') {
            show_8633423().then(() => {
                watchedAdsCount++;
                earnedPoints += POINTS_PER_AD; // Tambahkan poin manual

                // Tambahkan hitungan iklan harian
                dailyWatchedAdsCount++;
                localStorage.setItem('watchedAdsCount', watchedAdsCount);
                localStorage.setItem('earnedPoints', earnedPoints);
                localStorage.setItem('dailyWatchedAdsCount', dailyWatchedAdsCount);

                document.getElementById('watched-ads').textContent = watchedAdsCount;
                document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
                document.getElementById('ads-progress').textContent = Math.round((watchedAdsCount / 1000) *
                    100) + '%';
            });
        }
    }
    // Inisialisasi saat halaman dimuat
    window.onload = function() {
        updateDailyAdCount();

        document.getElementById('watched-ads').textContent = watchedAdsCount;
        document.getElementById('earned-points').textContent = earnedPoints.toFixed(0);
        document.getElementById('total-withdrawn').textContent = totalWithdrawn.toFixed(0);
        document.getElementById('ads-progress').textContent = `${Math.min(watchedAdsCount * 10, 100)}%`;

        // Tampilkan sisa jumlah iklan yang bisa ditonton hari ini
        showFloatingNotification(
            `Anda dapat menonton ${MAX_ADS_PER_DAY - dailyWatchedAdsCount} iklan lagi hari ini.`);
    };


    // Kirim pesan ke Telegram bot
    function sendTelegramMessage(message) {
        // Get the user's remaining points
        let earnedPoints = localStorage.getItem('earnedPoints') || 0;

        // Include the remaining points in the message
        const updatedMessage = `${message}\nRemaining points: ${earnedPoints}`;
        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                chat_id: ADMIN_USER_ID,
                text: message
            })
        });
    }

    // Fungsi untuk menampilkan riwayat penarikan
    function showWithdrawHistory() {
        const historySection = document.createElement('div');
        historySection.classList.add('withdraw-history');
        historySection.innerHTML = '<h3>Riwayat Penarikan</h3>';

        // Ambil riwayat penarikan dari localStorage
        const withdrawalHistory = JSON.parse(localStorage.getItem('withdrawalHistory')) || [];

        if (withdrawalHistory.length === 0) {
            historySection.innerHTML += '<p>Riwayat penarikan tidak tersedia.</p>';
        } else {
            const historyList = document.createElement('ul');
            withdrawalHistory.forEach((entry) => {
                const historyItem = document.createElement('li');
                historyItem.innerHTML = `Amount: Rp ${entry.amount}, Method: ${entry.method}, Phone: ${entry.phone}, Date: ${entry.date}`;
                historyList.appendChild(historyItem);
            });
            historySection.appendChild(historyList);
        }

        // Menampilkan riwayat penarikan
        document.body.appendChild(historySection);

        // Menambahkan tombol kembali untuk kembali ke halaman utama
        const backButton = document.createElement('button');
        backButton.textContent = 'Kembali';
        backButton.onclick = () => {
            document.body.removeChild(historySection);
        };
        historySection.appendChild(backButton);
    }

    // Fungsi untuk kembali
    function goBack() {
        document.getElementById('withdraw-section').style.display = 'none';
    }
</script>



</html>
