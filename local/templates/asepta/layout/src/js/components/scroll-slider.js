import Swiper from 'swiper';
import { throttle } from '~/js/helpers/utils';

export class ScrollSlider {
    constructor(el) {
        this.$slider = el;
        this.lastTop = 0;
        this.$swiper = null;

        this.init();
    }

    init() {
        window.addEventListener('scroll', throttle(() => {
            const scrollIsDown = this.scrollIsDown();

            if (!this.$swiper) return;
            

            if (scrollIsDown)
                this.$swiper.slideNext();
            else
                this.$swiper.slidePrev();
        }, 800));

        window.addEventListener('resize', () => {
            this.checkDestroySlider();
        });
        
        this.initNewSlider();
        this.checkDestroySlider();
    }

    initNewSlider() {
        const slider = new Swiper(this.$slider, {
            slidesPerView: 2.2,
            loopedSlides: 2,
            loop: true,
            centeredSlides: true,
            mousewheel: true,
        });

        this.$swiper = slider;
    }

    checkDestroySlider() {
        const width = window.innerWidth;
        
        if (width <= 1024) {
            this.$swiper ? this.$swiper.destroy() : null;
            this.$swiper = null;
        } else if (!this.$swiper)
            this.initNewSlider();   
    }

    scrollIsDown() {
        const st = window.pageYOffset || document.documentElement.scrollTop,
            localLastScrollTop = this.lastTop;

        this.lastTop = st <= 0 ? 0 : st;

        return st > localLastScrollTop;
    }

    changeSlide() {

    }
}