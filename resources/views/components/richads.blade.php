<script src="https://richinfo.co/richpartners/telegram/js/tg-ob.js"></script>
<script>
    window.TelegramAdsController = new TelegramAdsController();
    window.TelegramAdsController.initialize({
        pubId: "963604",
        appId: "1695",
    });


    function show_richads() {
        window.TelegramAdsController.triggerInterstitialBanner().then((result) => {
            sendWatchAdRequest();
        }).catch((result) => {
            clearInterval(interval);
            let btnWatch = document.getElementById('btnWatch')
            let btnCountdown = document.getElementById('btnCountdown')
            btnWatch.classList.remove('d-none');
            btnCountdown.classList.add('d-none');
        });

    }
</script>
