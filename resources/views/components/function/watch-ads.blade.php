<script>
    // Fungsi untuk menonton iklan manual (dengan pembatasan harian)
    function watchAd() {

        if (WATCHED_ADS_TODAY >= TASK_LIMIT) {
            showError('Batas harian menonton iklan tercapai. Silahkan kembali lagi besok ya kak 🙏');
            return;
        }
        window.navigator.vibrate(90);
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
                if(data.success == false) {
                    showError(data.message);
                }
                
                document.getElementById('watched-ads').textContent = data.user.watched_ads_count;
                document.getElementById('earnings').textContent = formatNumberShort(data.user.earned_points);
                document.getElementById("total-income").textContent = formatNumberShort(data.user.total_withdraw+data.user.earned_points);

                let taskLimitBar = document.getElementById("task-progress-bar");
                taskLimitBar.style.width = (data.user.watched_ads_count / data.task_limit) * 100 + "%";
                taskLimitBar.textContent = data.user.watched_ads_count + "/" + data.task_limit + " Task";
            });
        });
    }
</script>
