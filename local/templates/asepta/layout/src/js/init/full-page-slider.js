import { FullPageSlider } from '~/js/components/full-page-slider';

window.addEventListener('load', () => {
    $.each('[data-slider=full-page]', el => new FullPageSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=full-page]', wrap).forEach(el => new FullPageSlider(el));
    });
});
