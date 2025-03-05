<script>
    // Fungsi untuk menonton iklan manual (dengan pembatasan harian)
    function watchAd() {

        if (WATCHED_ADS_TODAY >= TASK_LIMIT) {
            showError('Batas harian menonton iklan tercapai. Silahkan kembali lagi besok ya kak 🙏');
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
                if(data.success == false) {
                    showError(data.message);
                }
                
                document.getElementById('watched-ads').textContent = data.user.watched_ads_count;
                document.getElementById('earnings').textContent = formatNumberShort(data.user.earned_points);
                let taskLimit = document.getElementById("task-limit");
                taskLimit.textContent = data.user.watched_ads_count + "/" + data.task_limit;
                console.log('ads shown')
            });
        });
    }
</script>
