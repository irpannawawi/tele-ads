<script>
    // Fungsi untuk menonton iklan manual (dengan pembatasan harian)
    adType = 0;
    console.log(adType)

    function sendWatchAdRequest() {
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
            if (data.success == false) {
                showError(data.message);
            }

            document.getElementById('watched-ads').textContent = data.user.watched_ads_count;
            document.getElementById('earnings').textContent = formatNumberShort(data.user
                .earned_points);
            document.getElementById("total-income").textContent = formatNumberShort(data.user
                .total_withdraw + data.user.earned_points);

            let taskLimitBar = document.getElementById("task-progress-bar");
            taskLimitBar.style.width = (data.user.watched_ads_count / data.task_limit) * 100 + "%";
            taskLimitBar.textContent = data.user.watched_ads_count + "/" + data.task_limit +
                " Task";
        });
    }

    function adMonetag() {
        show_{{ env('ADS_ID') }}().then((res) => {
            console.log(res)
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
                if (data.success == false) {
                    showError(data.message);
                }

                document.getElementById('watched-ads').textContent = data.user.watched_ads_count;
                document.getElementById('earnings').textContent = formatNumberShort(data.user
                    .earned_points);
                document.getElementById("total-income").textContent = formatNumberShort(data.user
                    .total_withdraw + data.user.earned_points);

                let taskLimitBar = document.getElementById("task-progress-bar");
                taskLimitBar.style.width = (data.user.watched_ads_count / data.task_limit) * 100 + "%";
                taskLimitBar.textContent = data.user.watched_ads_count + "/" + data.task_limit +
                    " Task";
            });
        });
    }

    // function adRichads() {
    //     return window.TelegramAdsController.triggerInterstitialBanner();
    // }

    function adDirectLink() {
        window.open('https://destisheem.com/4/9062646', '_blank');
    }

    function adDirectLink2() {
        window.open('https://suggestbingo.com/hfwfwc2gfz?key=29731af3edcb8907d1c27d4986b092cd', '_blank');
    }


    function watchAd() {
        if (WATCHED_ADS_TODAY >= TASK_LIMIT) {
            showError('Batas harian menonton iklan tercapai. Silahkan kembali lagi besok ya kak 🙏');
            return;
        }
        // if type = 0 

        if ("vibrate" in navigator) {
            navigator.vibrate(90);
        } else {
            console.log("Vibration API tidak didukung di browser ini.");
        }
        switch (adType) {
            case 0:
                adMonetag();
                adType = Math.floor(Math.random() * 3);
                break;
            case 1:
                adDirectLink();
                sendWatchAdRequest();
                adType = Math.floor(Math.random() * 3)
                break;
            case 2:
                adDirectLink2();
                sendWatchAdRequest();
                adType = Math.floor(Math.random() * 3)
                break;
        }
    }
</script>
