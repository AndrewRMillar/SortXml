(function() {
    const ratings = Array.from(document.querySelectorAll('.stars-inner'));
    const starTotal = 5;

    const rating = ratings.forEach((el) => {
        const rating = el.dataset.rating;
        const starPercentage = (rating / starTotal) * 100;
        const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
        el.style.width = starPercentageRounded;
    });
})();