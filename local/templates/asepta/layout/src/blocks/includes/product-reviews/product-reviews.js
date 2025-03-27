function hideAllReviewsBtn() {
    const reviews = document.querySelectorAll('.product-reviews__slider-item');
    const allReviewBtn = document.querySelector('.product-reviews__btn');
    if (allReviewBtn && reviews && (reviews.length < 3)) {
        allReviewBtn.classList.add('is-hidden');
    } else if (allReviewBtn && reviews && (reviews.length >= 3)) {
        allReviewBtn.classList.remove('is-hidden');
    }
}

export default hideAllReviewsBtn;
