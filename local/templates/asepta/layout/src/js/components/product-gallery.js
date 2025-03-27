import Swiper from 'swiper';
import { debounce, computedStyle } from '~/js/helpers/utils';

import { Thumbs, FreeMode, Pagination, Navigation } from 'swiper/modules';

Swiper.use([Thumbs, FreeMode, Pagination, Navigation]);

export class ProductGallery {
    constructor(el) {
        this.$slidersWrapper = el;
        this.$slider = $.qs('[data-slider-body]', el);
        this.$sliderThumbs = $.qs('[data-slider-thumbs]', el);
        this.$startWidth = window.innerWidth;
        this.navigation = {
            next: $.qs('[data-slider-next]', this.$slider),
            prev: $.qs('[data-slider-prev]', this.$slider),
        };
        this.isRatio = this.$slider.dataset.sliderRatio !== undefined;

        this.init();
    }

    init() {
        let sliderThumb = new Swiper(this.$sliderThumbs, {
            slidesPerView: 'auto',
            spaceBetween: 16,
            freeMode: true,
        });

        const { next, prev } = this.navigation;

        new Swiper(this.$slider, {
            loop: true,
            slidesPerView: 1,
            navigation: {
                prevEl: prev,
                nextEl: next,
            },
            thumbs: {
                swiper: sliderThumb,
            },
            on: this.isRatio ? {
                slideChange: (e) => {
                    const activeSlide = $.qsa('.swiper-slide', this.$slider)[e.activeIndex],
                        image = $.qs('img', activeSlide);
                    
                    this.getImageSize(image.src);
                },
            } : null,
        });

        const slidesLength = $.qsa('.swiper-slide', this.$slider).length;

        if (slidesLength <= 1)
            this.$sliderThumbs.style.display = 'none';

        window.addEventListener('resize', debounce(() => { 
            if (window.innerWidth == this.$startWidth) return;
            
            this.checkThumbsState(); 
            this.$startWidth = window.innerWidth;
        }, 100));
        
        this.checkThumbsState();
        
        if (this.isRatio)
            this.getImageSize($.qsa('.swiper-slide img', this.$slider)[0].src);
    }

    getImageSize(imgSrc) {
        let image = new Image();

        image.onload = () => {
            const height = image.height,
                width = image.width;

            this.setImageSize({ width, height });
        };

        image.src = imgSrc;
    }

    setImageSize(size) {
        this.$slider.style.aspectRatio = `${size.width} / ${size.height}`;
    }

    checkThumbsState() {
        const slider = this.$sliderThumbs,
            sliderWrapper = $.qs('.swiper-wrapper', slider);

        const sliderWidth = slider.getBoundingClientRect().width,
            sliderWrapperWidth = sliderWrapper.getBoundingClientRect().width,
            padding = computedStyle(slider, 'padding-left') + computedStyle(slider, 'padding-right');

        if (sliderWrapperWidth + padding - 1 > sliderWidth)
            sliderWrapper.classList.add('overflow-slider-wrapper');
        else
            sliderWrapper.classList.remove('overflow-slider-wrapper');
    }
}