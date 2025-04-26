<script src="https://richinfo.co/richpartners/telegram/js/tg-ob.js"></script>
<script>
    window.TelegramAdsController = new TelegramAdsController();
    window.TelegramAdsController.initialize({
        pubId: "961756",
        appId: "1798",
        
    });


    function show_richads() {
        window.TelegramAdsController.triggerNativeNotification().then((result) => {
            localStorage.setItem("richads_watched", new Date().getDate());
            sendWatchAdRequest();

        }).catch((result) => {
            adMonetag()
            // let btnWatch = document.getElementById('btnWatch')
            // let btnCountdown = document.getElementById('btnCountdown')
            // btnWatch.classList.remove('d-none');
            // btnCountdown.classList.add('d-none');
            // clearInterval(interval);
            //adMonetag
        });

    }

    function show_richads_inter() {
        window.TelegramAdsController.triggerInterstitialBanner(true).then((result) => {
            localStorage.setItem("richads_watched_inter", new Date().getDate());
            sendWatchAdRequest();

        }).catch((result) => {
            adGigapub()
            // let btnWatch = document.getElementById('btnWatch')
            // let btnCountdown = document.getElementById('btnCountdown')
            // btnWatch.classList.remove('d-none');
            // btnCountdown.classList.add('d-none');
            // clearInterval(interval);
        });

    }
</script>
