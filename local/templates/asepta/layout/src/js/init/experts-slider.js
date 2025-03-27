import { ExpertsSlider } from '~/js/components/experts-slider';

window.addEventListener('load', () => {
    $.each('[data-slider=experts-slider]', el => new ExpertsSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=experts-slider]', wrap).forEach(el => new FullPageSlider(el));
    });
});
