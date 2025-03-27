import { MobileFullSlider } from '~/js/components/mobile-full-slider';

window.addEventListener('load', () => {
    $.each('[data-slider=mobile-full]', el => new MobileFullSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=mobile-full]', wrap).forEach(el => new MobileFullSlider(el));
    });
});
