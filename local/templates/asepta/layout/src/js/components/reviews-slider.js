import Swiper from 'swiper';
import { Navigation, Scrollbar } from 'swiper/modules';

Swiper.use([Navigation, Scrollbar]);

export class ReviewsSlider {
    constructor(el) {
        this.$slider = el;
        this.navigation = {
            prev: $.qs('[data-slider-prev]', el),
            next: $.qs('[data-slider-next]', el),
        };
        this.$scrollbar = $.qs('[data-slider-scrollbar]', el);
        this.init();
    }
  
    init() {
        const { prev, next } = this.navigation;
        const scrollbar = this.$scrollbar;

        new Swiper(this.$slider, {
            slidesPerView: 'auto',
            spaceBetween: 12,
            navigation: {
                prevEl: prev,
                nextEl: next,
            },
            scrollbar: scrollbar ? {
                el: scrollbar,
                draggable: true,
            } : false,
            breakpoints: {
                1024: {
                    spaceBetween: 24,
                },
            },
        });
    }
}
  