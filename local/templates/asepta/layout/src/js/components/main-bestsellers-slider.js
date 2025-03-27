import Splide from '@splidejs/splide';
import '@splidejs/splide/dist/css/splide.min.css';
export class MainBestsellerSlider {
    constructor(el) {
        this.$slider = el;
        this.navigation = {
            prev: $.qs('[data-slider-prev]', el),
            next: $.qs('[data-slider-next]', el),
        };
        this.$scrollbar = $.qs('[data-slider-scrollbar]', el);
        this.isLoop = el.dataset.loop !== undefined;
        this.initBreakPoint = +el.dataset.initBreakpoint;
        this.splide = null;
        this.init();
    }

    init() {
        const splide = new Splide(this.$slider, {
            type: 'loop',
            drag: window.matchMedia('(max-width: 1024px)').matches ? true : false,
            autoWidth: true,
            focus: 'center',
            arrows: false,
            gap: 20,
            perMove: 1,
            pagination: false,

        });

        let slideIndex = 0;
        let direction = '';
        let isMaxTablet = window.matchMedia('(max-width: 1024px)').matches;
        const speed = 300;

        this.navigation.next.onclick = () => arrowHandler('next');
        this.navigation.prev.onclick = () => arrowHandler('prev');


        splide.on('mounted', () => {
            if (!isMaxTablet) {
                setActiveSlide();
            }

            setTimeout(() => {
                window.dispatchEvent(new Event('resize', { bubbles: true }));
            }, 3000);
        });

        function arrowHandler(state) {
            if (state === 'next') {
                direction = '>';
                slideIndex = splide.index + 1 === splide.length ? 0 : splide.index + 1;
            }

            if (state === 'prev') {
                direction = '<';

                slideIndex = splide.index - 1 === -1 ? splide.length - 1 : splide.index - 1;
            }

            if (isMaxTablet) {
                slider.go(direction);
            } else {
                setActiveSlide();
            }
        }

        function setActiveSlide() {
            if (slideIndex?.toString()) {
                splide.Components.Slides.get(true).forEach(slide => slide.slide.classList.remove('is-big'));
                splide.Components.Slides.get(true)[slideIndex].slide.classList.add('is-big');

                disableArrows();

                $.dispatch({
                    el: document,
                    name: 'popularSlideChange',
                });

                setTimeout(() => {
                    splide.go(direction);
                    enableArrows();
                }, speed);
            } else {
                throw new Error(`Некорректный индекс слайда: slideIndex = ${slideIndex}`);
            }
        }

        const disableArrows = () => {
            [this.navigation.next, this.navigation.prev].forEach(arrow => arrow.setAttribute('disabled', 'disabled'));
        };

        const enableArrows = () => {
            [this.navigation.next, this.navigation.prev].forEach(arrow => arrow.removeAttribute('disabled'));
        };

        splide.mount();
    }
}
