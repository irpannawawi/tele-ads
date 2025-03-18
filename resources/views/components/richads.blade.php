<script src="https://richinfo.co/richpartners/telegram/js/tg-ob.js"></script>
<script>
    window.TelegramAdsController = new TelegramAdsController();
    window.TelegramAdsController.initialize({
        pubId: "963604",
        appId: "1791",
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
        });

    }
</script>
