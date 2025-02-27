<!-- Fungsi untuk menampilkan informasi rate point -->
<script>
    function showRatePointInfo() {
        const notification = document.getElementById('floating-notification1');
        const ratePoint = document.getElementById('rate-point');
        ratePoint.textContent = POINTS_PER_AD.toFixed(0);
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.bottom = '50px';
            setTimeout(() => {
                notification.style.display = 'none';
                notification.style.bottom = '-50px';
            }, 5000);
        }, 100);
    }
</script>
<!-- / Fungsi untuk menampilkan informasi rate point -->
