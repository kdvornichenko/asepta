import { ProductGallery } from '~/js/components/product-gallery';

window.addEventListener('load', () => {
    $.each('[data-slider-wrapper]', el => new ProductGallery(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-slider-wrapper]', wrap).forEach(el => new ProductGallery(el));
    });
});
