<script>
    // Fungsi untuk menonton iklan otomatis
    let autoAdsInterval;
    let isAdPlaying = false;
    let lastInterval = 0;
    document.getElementById('auto-ad-btn').style.display = 'inline-block';
    document.getElementById('stop-auto-btn').style.display = 'none';
    // Fungsi untuk menghasilkan interval waktu acak (dalam milidetik)
    function getRandomInterval(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function startAutoAds() {
        function runAd() {
            todayWatched();

            if (WATCHED_ADS_TODAY >= MAX_ADS_PER_DAY) {
                showFloatingNotification('Batas harian menonton iklan tercapai. Silahkan kembali lagi besok ya kak 🙏');
                isAdPlaying = false;
                return;
            }
            if (!isAdPlaying) {
                isAdPlaying = true; // Tandai bahwa iklan sedang berjalan
                show_9012660()
                    .then(() => {
                        fetch("{{ url('/ads/watch') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                phone: userData?.id,
                                _token: '{{ csrf_token() }}'
                            }),
                        }).then(response => response.json()).then(data => {
                            console.log(data)
                            todayWatched();

                            document.getElementById('watched-ads').textContent = data.user
                                .watched_ads_count;
                            document.getElementById('earned-points').textContent = data.user.earned_points;
                            console.log('ads shown')
                        });

                        isAdPlaying = false;

                        lastInterval = getRandomInterval(2700, 4300);
                        autoAdsInterval = setTimeout(runAd, lastInterval);
                        loadWithdrawHistory(data.all_withdrawals);
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
</script>
