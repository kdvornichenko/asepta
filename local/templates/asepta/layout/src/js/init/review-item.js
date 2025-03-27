import { ReviewItem } from '~/js/components/review-item';

window.addEventListener('load', () => {
    $.each('[data-review-item]', el => new ReviewItem(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-review-item]', wrap).forEach(el => new ReviewItem(el));
    });
});
