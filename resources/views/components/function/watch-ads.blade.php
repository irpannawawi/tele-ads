<script defer>
    // Fungsi untuk menonton iklan manual (dengan pembatasan harian)


    function sendWatchAdRequest() {
        fetch("{{ url('/ads/watch') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                phone: userData?.id,
                token: document.querySelector('meta[name="token"]').getAttribute('content'),
                _token: '{{ csrf_token() }}'
            }),
        }).then(response => response.json()).then(data => {
            if (data.success == false) {
                showError(data.message);
            }
            if (data.user.token != null) {
                changeToken(data.user.token);
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
                token: document.querySelector('meta[name="token"]').getAttribute('content'),

                    _token: '{{ csrf_token() }}'
                }),
            }).then(response => response.json()).then(data => {
                if (data.success == false) {
                    showError(data.message);
                }

                if (data.user.token != null) {
                    changeToken(data.user.token);
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
        if (localStorage.getItem("richads_watched") != null && localStorage.getItem("richads_watched") < new Date()
            .getDate()) {
            adMonetag();
        } else {
            show_richads();
        }
    }

    function adRichadsInter() {
        if (localStorage.getItem("richads_watched_inter") != null && localStorage.getItem("richads_watched_inter") <
            new Date().getDate()) {
            adMonetag();
        } else {
            show_richads_inter();
        }
    }


    function adGigapub() {
        window.showGiga()
            .then(() => {
                sendWatchAdRequest();
            })
            .catch(e => {
                console.log("gigapub error")
                console.log(e)
                adMonetag();
            });

    }

    window.initCdTma({ id: 6064033 }).then(show => window.show = show).catch(e => console.log(e))
    function adOnclicka() {
       window.show?.().then(() =>{
            console.log("oneclicka success")
           sendWatchAdRequest();
       }).catch(e => {
            console.log("oneclicka error")
            console.log(e)
            adGigapub();
       })
       setTimeout(() => {
        console.log("oneclicka click")
           document.querySelector(".vast_player_click_link")?.click();
        
       }, 4322);
    }

    window.initCdTma?.({ id: 2007575 }).then(mybid => window.mybid = mybid).catch(e => console.log(e))
    function adMybid(){
        window.mybid?.().then(() =>{
            console.log("oneclicka success")
           sendWatchAdRequest();
       }).catch(e => {
            console.log("oneclicka error")
            console.log(e)
            adGigapub();
       })
       setTimeout(() => {
        console.log("oneclicka click")
           document.querySelector(".vast_player_click_link")?.click();
        
       }, 4322);
    }

    // ad 6
    function adDramax() {
        window.open('https://s.id/dramax', '_blank');
        sendWatchAdRequest();
    }
    const weightedArray = [0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 6]; 
    // 0 => 2x
    // 1 => 3x
    // 2 => 3x
    // 3 => 3x 
    // 4 => 3x 
    // 5 => 2x
    // 6 = 1x
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
        
        adType = weightedArray[Math.floor(Math.random() * weightedArray.length)];
        switch (adType) {
            case 0:
                adMonetag();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)];
                break;
            case 1:
                adOnclicka();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)]
                break;
            case 2:
                adRichads();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)]
                break;
            case 3:
                adRichadsInter();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)]
                break;
            case 4:
                adMybid();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)]
                break;
                
            case 5:
                adGigapub();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)]
                break;
            case 6:
                adDramax();
                adType = weightedArray[Math.floor(Math.random() * weightedArray.length)]
                break;
        }
    }
</script>
