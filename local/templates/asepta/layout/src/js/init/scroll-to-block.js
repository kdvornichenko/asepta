import { ScrollToBlock } from '../components/scroll-to-block';

window.addEventListener('load', () => {
    $.each('[data-scroll-to-block]', el => new ScrollToBlock(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-scroll-to-block]', wrap).forEach(el => new ScrollToBlock(el));
    });
});
