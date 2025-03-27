import Swiper from 'swiper';
import { Autoplay, Pagination } from 'swiper/modules';

Swiper.use([Autoplay, Pagination]);

export class FullPageSlider {
    constructor(el) {
        this.$slider = el;
        this.autoplayDelay = 5000;
        this.$progress = $.qs('[data-slider-progress]', el);
        this.$pagination = $.qs('[data-slider-pagination]', el);

        this.init();
    }

    init() {
        const context = this;
        const slider = new Swiper(this.$slider, {
            init: false,
            slidesPerView: 1,
            loop: true,
            allowTouchMove: true,
            autoplay: {
                delay: this.autoplayDelay,
                disableOnInteraction: false,
            },
            pagination: this.$pagination ? {
                el: this.$pagination,
                clickable: true,
            } : false,
            breakpoints: {
                768: {
                    allowTouchMove: false,
                },
            },
            on: {
                autoplayTimeLeft(s, time, progress) {
                    context.$progress && context.$progress.style.setProperty('--progress', Math.ceil((1 - progress) * 100) + '%');
                },
            },
        });

        if (window.innerWidth < 768) {
            slider.init();
            return;
        }

        slider.init();

        if (slider.slides.length === 1) {
            slider.destroy();
            this.$slider.classList.add('is-single');
        }
    }
}
