import Swiper from 'swiper';
import { Navigation, Scrollbar } from 'swiper/modules';

Swiper.use([Navigation, Scrollbar]);

export class LoopLineSlider {
    constructor(el) {
        this.$slider = el;
        this.navigation = {
            prev: $.qs('[data-slider-prev]', el),
            next: $.qs('[data-slider-next]', el),
        };
        this.$scrollbar = $.qs('[data-slider-scrollbar]', el);
        this.isLoop = el.dataset.loop !== undefined;
        this.initBreakPoint = +el.dataset.initBreakpoint;
        this.swiper = null;
        this.init();
    }

    init() {
        const { prev, next } = this.navigation;
        const scrollbar = this.$scrollbar;
        this.swiper = new Swiper(this.$slider, {
            init: false,
            loop: this.isLoop,
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: -55,
            observer: true,
            resizeObserver: false,
            observeParents: true,
            observeSlideChildren: true,
            slideToClickedSlide:true,
            navigation: {
                prevEl: prev,
                nextEl: next,
            },
            scrollbar: {
                el: scrollbar,
                draggable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                    loopedSlides: 2,
                },
            },
        });

        if (!this.initBreakPoint) {
            this.swiper.init();
            return;
        }

        window.addEventListener('resize', () => {
            this.chechkInit();
        });

        this.chechkInit();
    }

    chechkInit() {
        if (window.innerWidth <= this.initBreakPoint)
            this.swiper.init();
    }
}
