import { LoopLineSlider } from '~/js/components/loop-line-slider';

window.addEventListener('load', () => {
    $.each('[data-slider=loop-line]', el => new LoopLineSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=loop-line]', wrap).forEach(el => new LoopLineSlider(el));
    });
});
