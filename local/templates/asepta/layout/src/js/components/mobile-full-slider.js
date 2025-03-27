import Swiper from 'swiper';
import { Scrollbar } from 'swiper/modules';

Swiper.use([Scrollbar]);

export class MobileFullSlider {
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
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 7,
            scrollbar: {
                el: scrollbar,
                draggable: true,
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
  