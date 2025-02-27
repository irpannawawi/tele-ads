<script>
    // Fungsi untuk menonton iklan manual (dengan pembatasan harian)
    function watchAd() {
        todayWatched();

        if (WATCHED_ADS_TODAY >= MAX_ADS_PER_DAY) {
            showFloatingNotification('Batas harian menonton iklan tercapai. Silahkan kembali lagi besok ya kak 🙏');
            return;
        }

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
                todayWatched();
                if(data.success == false) {
                    showError(data.message);
                }
                document.getElementById('watched-ads').textContent = data.user.watched_ads_count;
                document.getElementById('earned-points').textContent = data.user.earned_points;
                console.log('ads shown')
            });
        });
    }
</script>
