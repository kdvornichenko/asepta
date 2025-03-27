import { MainBestsellerSlider } from '~/js/components/main-bestsellers-slider';

function initMainBestsellersSlider() {
    document.addEventListener('DOMContentLoaded', () => {
        $.each('[data-slider=main-bestseller]', el => new MainBestsellerSlider(el));

        document.addEventListener('frontend:reload', e => {
            const wrap = e.detail.wrap;
            if (!wrap) return;
            $.qsa('[data-slider=main-bestseller]', wrap).forEach(el => new MainBestsellerSlider(el));
        });
    });

}
export default initMainBestsellersSlider;
