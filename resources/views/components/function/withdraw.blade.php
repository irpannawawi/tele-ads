<script>
    // Fungsi untuk menampilkan formulir penarikan
    function showWithdrawForm() {
        document.getElementById('withdraw-section').style.display = 'block';
    }



    // Fungsi untuk melakukan penarikan
    function withdraw() {
        let withdrawAmount = document.getElementById('withdraw-amount').value;
        let phone = document.getElementById('withdraw-phone').value;
        let paymentMethod = document.getElementById('payment-method').value;

        fetch("{{ route('user.requestWithdraw') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                amount: withdrawAmount,
                method: paymentMethod,
                phone: userData.id,
                address: phone,

            })
        }).then(response => response.json()).then(data => {
            if (data.success) {
                showSuccess(data.message);
                // Kirim pesan ke Telegram Bot
                document.getElementById('earned-points').textContent = data.user.earned_points.toFixed(0);
                document.getElementById('total-withdrawn').textContent = data.user.total_withdraw.toFixed(0);
                document.getElementById('withdraw-btn').textContent = "Withdraw Success!";
                document.getElementById('withdraw-amount').value = "";
                document.getElementById('withdraw-phone').value = "";
                loadWithdrawHistory(data.all_withdrawals);
            } else {
                document.getElementById('withdraw-btn').textContent = "Withdraw Failed!";
                showError(data.message);
            }
            setTimeout(() => {
                document.getElementById('withdraw-btn').textContent = "Withdraw";
            }, 3000);

            goBack();
        })



    }
</script>
