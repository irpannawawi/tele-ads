<!-- Fungsi untuk menampilkan riwayat penarikan -->
<script>
    function showWithdrawHistory() {
        document.getElementById('withdraw-history').style.display = 'block';
    }

    function hideWithdrawHistory() {
        document.getElementById('withdraw-history').style.display = 'none';
    }

    function loadWithdrawHistory(data) {


        if (data.length === 0) {
            historySection.innerHTML += '<p>Riwayat penarikan tidak tersedia.</p>';
        } else {
            const historyList = document.getElementById('list-withdraw-history');
            data.forEach((entry) => {
                const historyItem = document.createElement('li');
                const dateStr = entry.created_at;
                let date = new Date(dateStr);

                let formattedDate = new Intl.DateTimeFormat('id-ID', {
                    day: 'numeric',
                    month: 'long', // Nama bulan dalam bahasa Indonesia
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false, // Gunakan format 24 jam
                }).format(date);
                
                historyItem.innerHTML =
                    `Amount: Rp ${entry.amount}, Method: ${entry.method}, Phone: ${entry.address}, Date: ${formattedDate}, Status: ${entry.status}, Note: ${entry.note==null?"-":entry.note}`;
                historyList.appendChild(historyItem);

            });


            historySection.appendChild(historyList);
        }

        // Menampilkan riwayat penarikan
        document.body.appendChild(historySection);

    }
</script>
<!-- / Fungsi untuk menampilkan riwayat penarikan -->
