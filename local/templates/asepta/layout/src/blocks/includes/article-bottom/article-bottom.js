import Swiper from 'swiper';
import { Scrollbar } from 'swiper/modules';

class ArticleFullSlider {
    constructor(el) {
        this.$slider = el;
        this.$scrollbar = $.qs('[data-slider-scrollbar]', el);
        this.widthInit = el.dataset.widthInit || 500;
        this.swiper = null;
        this.init();
    }

    init() {
        if (this.swiper && this.swiper.initialized) return;

        Swiper.use([Scrollbar]);

        const scrollbar = this.$scrollbar;

        const slider = new Swiper(this.$slider, {
            init: false,
            slidesPerView: 1.2,
            spaceBetween: 20,
            scrollbar: {
                el: scrollbar,
                draggable: true,
            },
            breakpoints: {
                500: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });

        this.swiper = slider;

        window.addEventListener('resize', () => {
            if (window.innerWidth <= this.widthInit) {
                slider.init();
            } else {
                slider.initialized && slider.destroy(true, true);
            }
        });

        if (window.innerWidth <= this.widthInit)
            slider.init();
    }
}

function articleBottom(page) {
    initSliders(page);

    document.addEventListener('frontend:reload', () => initSliders(page));
}

function initSliders(page) {
    const fullSliders = $.qsa('[data-slider-article="mobile-full"]', page);

    fullSliders.forEach(slider => {
        new ArticleFullSlider(slider);
    });
}

export default articleBottom;