import { CoverflowSlider } from '~/js/components/coverflow-slider';

function coverflowSlider() {
    $.each('[data-slider=coverflow]', el => new CoverflowSlider(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider=coverflow]', wrap).forEach(el => new CoverflowSlider(el));
    });
}

export default coverflowSlider;