import Swiper from 'swiper';
import { EffectCoverflow, Scrollbar } from 'swiper/modules';

Swiper.use([EffectCoverflow, Scrollbar]);

export class CoverflowSlider {
    constructor(el) {
        this.$slider = el;
        this.$scrollBar = $.qs('[data-slider-scrollbar]', el);
        this.$slides = $.qsa('[data-slot="slide"]', this.$slider);
        this.$sliderWrapper = $.qs('[data-slot="slider-wrapper"]', this.$slider); // Slider wrapper находим сразу же, потому что слайдер может инициализироваться нерабочим (для десктопа) и обертки не будет
        this.savedSlides = { first: null, last: null }; // Сохраняем слайды, которые будут удаляться
        this.swiper = null;
        this.init();
    }

    init() {
        this.initSwiper();
        this.handleResize();
        window.addEventListener('resize', () => this.handleResize());
    }

    initSwiper() {
        this.swiper = new Swiper(this.$slider, {
            slidesPerView: 'auto',
            initialSlide: 2,
            effect: 'coverflow',
            speed: 200,
            resistanceRatio: 0.5,
            coverflowEffect: {
                rotate: 0,
                slideShadows: false,
                stretch: 0,
                depth: 100,
                modifier: 1,
                scale: 0.7,
            },
            scrollbar: {
                el: this.$scrollBar,
                draggable: true,
            },
            spaceBetween: 0,
            centeredSlides: false,
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    initialSlide: 2,
                },
                1025: {
                    effect: null,
                    slidesPerView: 5,
                    centeredSlides: false,
                },
            },
        });
    }

    handleResize() {
        if (window.innerWidth < 768) {
            this.removeHiddenSlides();
        } else {
            // this.restoreHiddenSlides();
        }
    }

    removeHiddenSlides() {
        if (!this.savedSlides.first && !this.savedSlides.last) {
            const firstSlide = this.$slides[0];
            const lastSlide = this.$slides.at(-1);

            if (firstSlide) {
                this.savedSlides.first = firstSlide.cloneNode(true);
                firstSlide.remove();
            }

            if (lastSlide) {
                this.savedSlides.last = lastSlide.cloneNode(true);
                lastSlide.remove();
            }

            this.refreshSwiper();
        }
    }

    // restoreHiddenSlides() {
    //     if (this.savedSlides.first && !this.$slides.includes(this.savedSlides.first)) {
    //         this.$sliderWrapper.prepend(this.savedSlides.first);
    //         this.$slides.unshift(this.savedSlides.first);
    //         this.savedSlides.first = null;
    //     }

    //     if (this.savedSlides.last && !this.$slides.includes(this.savedSlides.last)) {
    //         this.$sliderWrapper.append(this.savedSlides.last);
    //         this.$slides.push(this.savedSlides.last);
    //         this.savedSlides.last = null;
    //     }

    //     this.refreshSwiper();
    // }

    refreshSwiper() {
        this.swiper?.destroy(true, true);

        this.initSwiper();
    }
}
