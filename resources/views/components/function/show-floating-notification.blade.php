<script>
        // Fungsi untuk menampilkan notifikasi mengambang
        function showFloatingNotification(message) {
        const notification = document.getElementById('floating-notification');
        notification.textContent = message;
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.bottom = '177px';
            setTimeout(() => {
                notification.style.display = 'none';
                notification.style.bottom = '-50px';
            }, 5000);
        }, 100);
    }

</script>