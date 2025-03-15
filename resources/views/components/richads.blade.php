<script src="https://richinfo.co/richpartners/telegram/js/tg-ob.js"></script>
<script>
    window.TelegramAdsController = new TelegramAdsController();
    window.TelegramAdsController.initialize({
        pubId: "358310",
        appId: "1693",
    });


    function show_richads() {
        window.TelegramAdsController.triggerInterstitialBanner().then((result) => {
            sendWatchAdRequest();
        }).catch((result) => {
            let btnWatch = document.getElementById('btnWatch')
            let btnCountdown = document.getElementById('btnCountdown')
            btnWatch.classList.remove('d-none');
            btnCountdown.classList.add('d-none');
            clearInterval(interval);
        });

    }
</script>
