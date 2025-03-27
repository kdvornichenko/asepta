import { ScrollSlider } from '~/js/components/scroll-slider';

window.addEventListener('load', () => {
    $.each('[data-slider=scroll]', el => new ScrollSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=scroll]', wrap).forEach(el => new ScrollSlider(el));
    });
});
