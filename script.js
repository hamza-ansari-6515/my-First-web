// Banner Fade-in and Card Slide Animation
window.addEventListener('DOMContentLoaded', () => {
    let banners = document.querySelectorAll('.banner');
    banners.forEach((b, i) => { b.style.opacity = 0; setTimeout(() => { b.style.opacity = 1; }, 160 + i * 60); });

    let cards = document.querySelectorAll('.cat-card');
    cards.forEach((card, i) => { card.style.opacity = 0; setTimeout(() => { card.style.opacity = 1; }, 300 + i * 50); });

    // WhatsApp Button
    let wBtn = document.getElementById('wa-btn');
    if (wBtn) {
        wBtn.addEventListener('click', function () {
            window.open('https://wa.me/918320884933', '_blank');
        });
    }

    // Explore Button Bounce
    document.querySelectorAll('.explore-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            btn.style.transform = 'scale(1.13)';
            setTimeout(() => { btn.style.transform = 'scale(1)'; }, 150);
        });
    });
});
