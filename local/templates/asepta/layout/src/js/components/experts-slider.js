import Swiper from 'swiper';
import { Scrollbar } from 'swiper/modules';

Swiper.use([Scrollbar]);

export class ExpertsSlider {
    constructor(el) {
        this.$slider = el;
        this.$scrollbar = $.qs('[data-slider-scrollbar]', el);
        this.widthInit = el.dataset.widthInit || 500;
        this.init();
    }

    init() {
        const scrollbar = this.$scrollbar;

        const slider = new Swiper(this.$slider, {
            init: false,
            slidesPerView: 1.2,
            centeredSlides: false,
            spaceBetween: 12,
            scrollbar: {
                el: scrollbar,
                draggable: true,
            },
            breakpoints: {
                600: {
                    slidesPerView: 2.2,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth <= this.widthInit)
                slider.init();
        });

        if (window.innerWidth <= this.widthInit)
            slider.init();
    }
}
