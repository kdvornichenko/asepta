import { ReviewsSlider } from '~/js/components/reviews-slider';

window.addEventListener('load', () => {
    $.each('[data-slider=reviews]', el => new ReviewsSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=reviews]', wrap).forEach(el => new ReviewsSlider(el));
    });
});
