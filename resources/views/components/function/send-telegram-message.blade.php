<script>
        // Kirim pesan ke Telegram bot
        function sendTelegramMessage(message) {
        // Get the user's remaining points
        let earnedPoints = localStorage.getItem('earnedPoints') || 0;

        // Include the remaining points in the message
        const updatedMessage = `${message}\nRemaining points: ${earnedPoints}`;
        fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                chat_id: {{ env('ADMIN_USER_ID') }},
                text: message
            })
        });
    }
</script>