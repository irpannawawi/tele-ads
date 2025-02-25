
// Initialize Telegram WebApp
const tg = window.Telegram.WebApp;

// Expand WebApp to full height
tg.expand();

// Access user data
const user = tg.initDataUnsafe?.user;

// Check if user data is available
if (user) {
    // Display user's photo
    const userPhoto = document.getElementById('user-photo');
    if (user.photo_url) {
        userPhoto.src = user.photo_url;
    } else {
        userPhoto.src = 'https://via.placeholder.com/100'; // Placeholder if no photo
    }

    // Display user's name
    const userName = document.getElementById('user-name');
    userName.textContent = `Hallo, ${user.first_name} ${user.last_name || ''} (@${user.username || 'No username'})`;
} else {
    document.querySelector('.user-info').innerHTML = '<p>Data pengguna tidak tersedia</p>';
    // window.location.href = 'https://t.me/cuanads';
}
