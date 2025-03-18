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

    function adRichads() {
        if (localStorage.getItem("richads_watched") != null && localStorage.getItem("richads_watched") < new Date().getDate()) {
            adMonetag();
        } else {
            show_richads();
        }
    }

    function adDirectLink() {
        window.open('https://tecmugheksoa.com/4/9082169', '_blank');
    }

    function adGigapub() {
        window.showGiga()
            .then(() => {
                sendWatchAdRequest();
            })
            .catch(e => {
                let btnWatch = document.getElementById('btnWatch')
                let btnCountdown = document.getElementById('btnCountdown')
                btnWatch.classList.remove('d-none');
                btnCountdown.classList.add('d-none');
                clearInterval(interval);
            });

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
                adType = Math.floor(Math.random() * 4);
                break;
            case 1:
                adDirectLink();
                sendWatchAdRequest();
                adType = Math.floor(Math.random() * 4)
                break;
            case 2:
                adRichads();
                adType = Math.floor(Math.random() * 4)
                break;
            case 3:
                adGigapub();
                adType = Math.floor(Math.random() * 4)
                break;
        }
    }
</script>
