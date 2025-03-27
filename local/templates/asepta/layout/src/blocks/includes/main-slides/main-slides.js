import Splide from '@splidejs/splide';
import { AutoScroll } from '@splidejs/splide-extension-auto-scroll';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/all';
import Swiper from 'swiper';
import { Autoplay, EffectCreative, FreeMode, Mousewheel, Pagination } from 'swiper/modules';
import { lenis } from '~/js/init/smooth-scroll';

export class MainSlides {
    constructor(block) {
        this.$header = $.qs('[data-header]');
        this.$logo = this.getLogo();
        this.$logoSvg = $.qs('[data-header-logo-svg]', this.$header);

        this.$block = block;
        this.$slides = $.qsa('[data-slot="slide"]', this.$block);
        this.$pagination = $.qs('[data-slot="pagination"]', this.$block);

        /**
         * @typedef {Object} Sliders
         * @property {Swiper|null} main Основной слайдер (экземпляр Swiper)
         * @property {Splide[]|null} running Массив слайдеров Splide (экземпляр Splide)
         * @property {Swiper|null} coverflow Coverflow слайдер (экземпляр Swiper)
         * @property {Splide[]|null} reviews Массив слайдеров Splide (экземпляр Splide)
         */
        /** @type {Sliders} */
        this.sliders = {
            main: null,
            running: null,
            coverflow: null,
            reviews: null,
        };
        this.slide = {
            active: {
                el: null,
                name: null,
            },
            prev: {
                el: null,
                name: null,
            },
        };

        this.scrollForced = false;
        this.locked = false;

        this.ease = 'power3.inOut';
        this.duration = { default: 0.5, long: 1 };

        this.logoAnimated = false;
        this.isMobileCoverflowInited = false;
        this.hasEnded = false;

        this.animConfig = {
            wasAnimated: false,
            enter: () => null,
            exit: () => null,
        };

        this.animations = {
            logo: { ...this.animConfig },
            running: { ...this.animConfig },
            coverflow: { ...this.animConfig },
            reviews: { ...this.animConfig },
            parallax: { ...this.animConfig },
        };


        this.slideContents = this.hideSlideContents();

        this.init();
    }

    init() {
        this.initSliders();
        this.initSlideHandlers();

        // this.sliders.main.slideTo(2);
        // this.handleParallaxSlide().enter();

        this.scrollHandler();

        setTimeout(() => {
            lenis.scrollTo(-1, {
                immediate: true,
                onComplete: this.setScrollTrigger(),
            });

            // FIX для Safari
            window.scroll({ top: -1, left: 0 });
        }, 100);

        window.addEventListener('resize', () => {
            if (this.locked) this.scrollToBlock();
        });

        window.mainSlider = this;
    }

    hideSlideContents() {
        return this.$slides.reduce((acc, slide, index) => {
            const inner = $.qs('[data-slot="inner"]', slide);
            if (inner && index === 0) {
                gsap.set($.qsa('[data-anim-hide]', inner), { opacity: 0 }); // Скрываем контент слайдов
            }
            acc[index] = inner;
            return acc;
        }, {});
    }

    initSliders() {
        Swiper.use([Mousewheel, Pagination, Autoplay, FreeMode, EffectCreative]);

        // Основной слайдер
        this.sliders.main = new Swiper(this.$block, {
            direction: 'vertical',
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 700,
            mousewheel: {
                enabled: false,
                forceToAxis: true,
                sensitivity: 1.5,
                thresholdDelta: 15,
                eventsTarged: this.$block,
                thresholdTime: 500, // Минимальное время между переключениями
            },
            // enabled: false,
            pagination: {
                el: this.$pagination,
                modifierClass: 'main-slides__pagination-',
                bulletClass: 'main-slides__pagination-bullet',
                bulletActiveClass: 'is-active',
                clickable: true,
            },
            releaseOnEdges: true,
            thresholdDelta: 50,
            preventInteractionOnTransition: true,
            resistance: false,
            touchReleaseOnEdges: true,
            on: {
                slideChangeTransitionStart: e => this.handleSlideChange(e),
                init: e => {
                    const activeSlide = this.slide.active.el = e.slides[e.activeIndex];
                    const prevSlide = this.slide.prev.el = e.slides[e.previousIndex];

                    this.slide.active.name = activeSlide?.dataset.slideName;
                    this.slide.prev.name = prevSlide?.dataset.slideName;
                },
            },

        });

        // Слайдеры с бегущими линиями
        this.initRunningSliders();
    }

    /**
     * Инициализирует слайдер с автоматической прокруткой
     * @param {HTMLElement} selector - DOM элемент слайдера
     * @param {Splide.Options} options - Опции Splide слайдера
     * @returns {Splide} Экземпляр слайдера
     */
    initAutoScrollSlider(selector, options = {}) {
        return new Splide(selector, {
            autoWidth: true,
            type: 'loop',
            drag: 'free',
            arrows: false,
            pagination: false,
            ...options,
        });
    }

    initRunningSliders() {
        this.sliders.running = [];
        const runningSliders = $.qsa('[data-slot="running-slider"]', this.$block);

        runningSliders.forEach((slider, index) => {
            const speed = index === 0 ? 0.555555 : index === 1 ? -0.555555 : 0.888888;
            const mobileSpeed = index === 0 ? 0.333333 : index === 1 ? -0.333333 : 0.555555;

            const splide = this.initAutoScrollSlider(slider, {
                autoScroll: { speed },
                breakpoints: {
                    1024: {
                        autoScroll: { speed: mobileSpeed },
                    },
                },
            });

            this.sliders.running.push(splide);
        });
    }

    scrollHandler() {
        lenis.on('scroll', ({ scroll }) => {
            const currentScroll = Math.round(scroll);
            const blockTop = this.$block.offsetTop;

            // Сброс флагов при выходе за верхнюю границу блока
            if (currentScroll < blockTop) {
                this.scrollForced = false;
                this.locked = false;
            }

            if (this.scrollForced) return;

            // Основная логика блокировки
            if ((currentScroll > blockTop && !this.hasEnded) || (this.hasEnded && currentScroll < blockTop)) {
                this.scrollToBlock();
            }
        });
    }

    setScrollTrigger() {
        gsap.registerPlugin(ScrollTrigger);

        ScrollTrigger.create({
            trigger: this.$block,
            start: 'top-=10 top',
            markers: false,
            scrub: false,
            end: () => `+=${this.$block.offsetHeight}`,
        });

        ScrollTrigger.create({
            trigger: this.sliders.main.slides,
        });
    }

    scrollToBlock() {
        this.scrollForced = true;
        lenis.stop();

        this.locked = true;

        this.$header.classList.add('header--fixed');

        lenis.scrollTo(this.$block, {
            immediate: true,
            lock: true,
            force: true,
            onComplete: () => {
                // Автоматический сброс через 100ms после завершения
                setTimeout(() => {
                    this.scrollForced = false;
                    this.locked = false;
                }, 100);

                this.$block.classList.add('is-active');

                if (this.sliders.main.activeIndex === 0) {
                    this.addLogoSlideScrollEvents();

                    if (!this.animations.logo.wasAnimated) {
                        this.handleFirstSlide();
                    }
                }

                if (this.sliders.main.activeIndex === 4) {
                    this.enterBack = true;
                    this.handleParallaxSlide().enter();
                    this.hasEnded = false;
                } else {
                    this.sliders.main?.enable();
                }
            },
        });
    }

    interactionEnable() {
        this.sliders.main.enable();
        this.sliders.main.mousewheel.enable();
        this.sliders.main.pagination.el.classList.add('is-visible');
    }

    initSlideHandlers() {
        this.slideHandlers = {
            logo: () => this.handleLogoSlide(),
            running: () => this.handleRunningSlide(),
            coverflow: () => this.handleCoverflowSlide(),
            reviews: () => this.handleReviewsSlide(),
            parallax: () => this.handleParallaxSlide(),
        };
    }

    handleSlideChange(swiper) {
        const activeSlide = this.slide.active.el = swiper.slides[swiper.activeIndex];
        const prevSlide = this.slide.prev.el = swiper.slides[swiper.previousIndex];

        const activeSlideName = this.slide.active.name = activeSlide.dataset.slideName;
        const prevSlideName = this.slide.prev.name = prevSlide.dataset.slideName;

        this.slideHandlers[prevSlideName]()?.exit();
        this.slideHandlers[activeSlideName]()?.enter();
    }

    handleLogoSlide() {
        return {
            enter: () => {
                if (!this.animations.logo.wasAnimated && this.slideContents[0]) {
                    this.handleFirstSlide();
                }

                setTimeout(() => {
                    this.addLogoSlideScrollEvents();
                }, this.sliders.main.params.speed);
            },
            exit: () => {
                this.defaultExitAnimation();

                this.removeLogoSlideScrollEvents();
            },
        };
    }

    handleScroll(e) {
        if (e.deltaY < 0 && this.animations.logo.wasAnimated) {
            e.preventDefault();
            lenis.start();
            lenis.scrollTo(window.scrollY - 100);
            this.sliders.main.disable();

            this.$block.classList.remove('is-active');

            this.removeLogoSlideScrollEvents();
        }
    }

    handleSwipe(e) {
        if (!this.touchStartY) {
            this.touchStartY = e.touches[0]?.clientY;
        } else {
            const deltaY = this.touchStartY - e.changedTouches[0].clientY;
            this.touchStartY = null;

            if (deltaY > 30 && this.animations.logo.wasAnimated) {
                lenis.start();
                lenis.scrollTo(window.scrollY - 100);
                this.sliders.main.disable();

                this.removeLogoSlideScrollEvents();
            }
        }
    }

    addLogoSlideScrollEvents() {
        const firstSlide = this.sliders.main.slides[0];
        if (!this._scrollHandlerAdded) {
            this.wheelHandler = this.handleScroll.bind(this);
            this.swipeHandler = this.handleSwipe.bind(this);

            firstSlide.addEventListener('wheel', this.wheelHandler, { passive: false });
            firstSlide.addEventListener('touchstart', this.swipeHandler);
            firstSlide.addEventListener('touchend', this.swipeHandler);

            this._scrollHandlerAdded = true;
        }
    }

    removeLogoSlideScrollEvents() {
        const firstSlide = this.sliders.main.slides[0];
        if (this._scrollHandlerAdded) {
            firstSlide.removeEventListener('wheel', this.wheelHandler);
            firstSlide.removeEventListener('touchstart', this.swipeHandler);
            firstSlide.removeEventListener('touchend', this.swipeHandler);
            this._scrollHandlerAdded = false;
        }
    }

    handleFirstSlide() {
        if (this.animations.logo.wasAnimated) return;
        this.sliders.main.disable();
        this.sliders.main.allowTouchMove = false;

        const arrow = $.qs('[data-slot="logo-btn"]', this.slideContents[0]);

        arrow.onclick = () => this.sliders.main.slideNext();

        const timeline = this.logoAnimTimeline();
        let isAnimating = false; // Флаг для единоразового запуска анимации
        timeline.set(this.slideContents[0], { '--opacity-arrow': 0, '--scale-arrow': 0 });

        // Отслеживаем прогресс анимации логотипа
        timeline.eventCallback('onUpdate', () => {
            if (isAnimating) return;

            // На 70% выполнения запускаем анимацию inner
            if (timeline.progress() >= 0.7 && this.slideContents[0]) {
                const revealElems = $.qsa('[data-anim-hide]', this.slideContents[0]);
                gsap.timeline()
                    .to(revealElems, {
                        opacity: 1,
                        stagger: 0.3,
                        duration: this.duration.long,
                        ease: this.ease,
                        onComplete: () => {
                            gsap.to(this.slideContents[0], {
                                '--opacity-arrow': 1,
                                '--scale-arrow': 1,
                                duration: this.duration.long,
                                ease: 'power4.out',
                                onStart: () => this.interactionEnable(),
                                onComplete: () => {
                                    this.addLogoSlideScrollEvents();

                                    this.animations.logo.wasAnimated = true;
                                    this.sliders.main.allowTouchMove = true;
                                },
                            });
                        },
                    });

                isAnimating = true;
            }
        });
    }

    getLogo() {
        return $.qs('[data-header-logo]', this.$header);
    }

    logoAnimTimeline() {
        this.$header.classList.add('is-animating');

        const timeline = gsap.timeline({ defaults: { duration: this.duration.default } });
        const logoText = $.qs('[data-slot="logo-text"]', this.slideContents[0]);
        const logoTextSvg = $.qs('[data-slot="logo-text-svg"]', this.slideContents[0]);

        timeline
            .set(document.body, {
                '--header-logo-height': `${this.$logo.offsetHeight}px`,
            })
            .set(this.$logo, {
                width: '60vw',
                onComplete: () => {
                    gsap.set(logoText, {
                        '--title-offset': this.getLogo().offsetHeight / 2 + 'px',
                        width: '60vw',
                    });

                    gsap.set(logoTextSvg, { y: '-100%' });
                },
            })
            .set(this.$logo, {
                transform: () => {
                    const translate = window.innerHeight / 2 - this.$logo.offsetHeight / 2 + this.$header.offsetHeight / 2; // Центрируем изображение
                    return `translateY(${translate}px)`;
                },
            })
            .set(this.$logoSvg, { y: '100%' })
            .to(this.$logoSvg, {
                ease: this.ease,
                duration: this.duration.long,
                y: 0,
                onStart: () => {
                    gsap.to(logoTextSvg, {
                        ease: this.ease,
                        duration: this.duration.long,
                        y: 0,
                    });
                },
            })
            // После задержки отправляем лого обратно в шапку и отображаем шапку
            .to(this.$logo, {
                transform: 'translateY(0)',
                width: 166,
                duration: this.duration.long,
                delay: this.duration.default,
                ease: this.ease,
                onStart: () => {
                    gsap.to(this.$header, {
                        top: 0,
                        delay: this.duration.default / 2,
                        ease: this.ease,
                    });

                    gsap.to(logoText, {
                        y: '100%',
                        opacity: 0,
                        duration: this.duration.long,
                        ease: this.ease,
                    });
                },
                onComplete: () => {
                    this.$header.classList.remove('is-animating');
                    this.$header.classList.remove('header--hidden');
                    this.logoAnimated = true;
                },
            });

        // Возвращаем сам таймлайн для запуска анимаций текста в этом же таймлайне
        return timeline;
    }

    handleRunningSlide() {
        return {
            enter: () => {
                if (!this.animations.running.wasAnimated) {
                    this.sliders.running.forEach(slider => {
                        !slider.is(Splide.STATES.MOUNTED) && slider.mount({ AutoScroll });
                    });
                    this.animations.running.wasAnimated = true;
                } else {
                    this.sliders.running.forEach(slider => {
                        slider.Components.AutoScroll.play();
                    });
                }

                this.defaultEnterAnimation();
            },
            exit: () => {
                this.defaultExitAnimation();

                this.sliders.running.forEach(slider => {
                    setTimeout(() => {
                        slider.Components.AutoScroll.pause();
                    }, this.sliders.main.params.speed);
                });
            },
        };
    }

    handleCoverflowSlide() {
        return {
            enter: () => {
                const coverflowSlider = $.qs('[data-slot="coverflow-slider"]', this.slide.active.el);
                if (this.animations.coverflow.wasAnimated || !coverflowSlider) return;

                this.sliders.main.disable();

                const coverflowSliderInner = $.qs('[data-slot="inner"]', coverflowSlider);
                const coverflowSlides = $.qsa('[data-slot="slide"]', coverflowSlider);

                let isMobile = false;
                let isTablet = false;
                // Прячем блок перед анимацией появления
                gsap.set(coverflowSliderInner, {
                    y: '100%',
                    opacity: 0,
                });

                const slidesConfig = [
                    { // 1-й слайд
                        order: 3,
                        position: 1,
                        toCenter: 2,
                        rotateSmoothing: 1,
                        translateYInitial: -35,
                        rotate: 55,
                        maxHeight: '45vh',
                        hideOnTab: true,
                    },
                    { // 2-й слайд
                        order: 2,
                        position: 1,
                        toCenter: 1,
                        rotate: 45,
                        maxHeight: '50vh',
                    },
                    { // 3-й слайд - центральный
                        order: 0,
                        position: 0,
                        toCenter: 0,
                        rotate: 0,
                        maxHeight: '55vh',
                    },
                    { // 4-й слайд
                        order: 1,
                        position: -1,
                        toCenter: 1,
                        rotate: -45,
                        maxHeight: '50vh',
                    },
                    { // 5-й слайд
                        order: 4,
                        position: -1,
                        toCenter: 2,
                        rotateSmoothing: 1,
                        translateYInitial: -35,
                        rotate: -55,
                        maxHeight: '45vh',
                        hideOnTab: true,
                    },
                ];

                window.addEventListener('resize', () => this.slide.active.name === 'coverflow' && gsap.matchMediaRefresh());

                coverflowSlides.forEach((slide, index) => {
                    const config = slidesConfig[index];
                    const mm = gsap.matchMedia();

                    mm.add('(min-width: 1921px)', () => {
                        config.width = window.innerWidth / 7;
                        setConfigTranslates();
                    });

                    mm.add('(min-width: 1025px) and (max-width: 1920px)', () => {
                        config.width = window.innerWidth / 5;
                        setConfigTranslates();
                    });

                    mm.add('(max-width: 1024px)', () => {
                        config.width = 220;
                        config.hideOnTab && gsap.set(slide, { display: 'none' });
                        setConfigTranslates();

                        !isTablet && (isTablet = true);
                    });

                    mm.add('(max-width: 768px)', () => {
                        !isMobile && (isMobile = true);

                        if (!this.animations.coverflow.wasAnimated) return;
                        setConfigTranslates();

                        gsap.set(slide, {
                            x: config.translateX,
                        });
                    });

                    gsap.set(slide, {
                        x: config.width * config.toCenter * config.position,
                        y: config.order * -30,
                        z: config.order * -90,
                        width: config.width,
                        display: config.hideOnTab && isTablet ? 'none' : 'block',
                        maxHeight: config.maxHeight,
                    });

                    if (index === 2) {
                        gsap.utils.toArray('.catalog-card p span', slide).forEach(line => {
                            const p = line.parentElement;
                            const dist = (p.clientWidth - line.offsetWidth) / 2;
                            gsap.set(line, { x: dist });
                        });
                    }

                    function setConfigTranslates() {
                        const FULL_WIDTH = 3 * config.width;

                        // Расчёт доступного пространства
                        const windowWidth = window.innerWidth;
                        const freeSpace = Math.max(FULL_WIDTH - windowWidth, 0);

                        // Динамическое смещение для крайних карточек
                        const translateX = freeSpace > 0 ? (freeSpace / 2.5) * (windowWidth < FULL_WIDTH ? 1 : 0) : 0;

                        config.translateX = config.position * translateX;
                        config.translateY = (config.toCenter || 0) * (config.translateYInitial || -70);
                    }
                });

                setTimeout(() => {
                    const timeline = gsap.timeline();

                    timeline.to(coverflowSliderInner, {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: 'back.inOut(1.2)',
                        onComplete: () => {
                            coverflowSlides.forEach((slide, index) => {
                                const { translateX, translateY, rotate } = slidesConfig[index];
                                if (!slidesConfig[index]) return;

                                gsap.to(slide, {
                                    x: translateX,
                                    y: translateY,
                                    z: index === 2 ? 0 : -40,
                                    rotationY: rotate,
                                    duration: 3,
                                    ease: 'elastic.out(1,0.6)',
                                    overwrite: 'auto',
                                    onComplete: () => {
                                        coverflowSlider.classList.add('was-animated');
                                        window.dispatchEvent(new Event('resize', { bubbles: true }));
                                        this.sliders.main.enable();

                                        // Добавляем свайп только на мобильных
                                        if (window.innerWidth <= 1024 && !this.isMobileCoverflowInited) {
                                            this.initMobileCoverflowSwipe(coverflowSliderInner, coverflowSlides, slidesConfig);
                                        }
                                    },
                                });
                            });

                            this.animations.coverflow.wasAnimated = true;
                        },
                    });
                }, this.sliders.main.params.speed / 2);
            },
            exit: () => this.defaultExitAnimation(),
        };
    }

    initMobileCoverflowSwipe(coverflowSlider, coverflowSlides, slidesConfig) {
        this.isMobileCoverflowInited = true;
        let activeIndex = 1;
        const SWIPE_THRESHOLD = 50;
        const ANIMATION_DURATION = 0.6;
        const ROTATION_MAP = {
            0: { 1: '0deg', 2: '-45deg', 3: '-45deg' },
            1: { 1: '45deg', 2: '0deg', 3: '-45deg' },
            2: { 1: '45deg', 2: '45deg', 3: '0deg' },
        };

        function handlePointerDown(e) {
            e.preventDefault();
            this.isDragging = true;
            this.startX = e.clientX;
        }

        function handlePointerUp(e) {
            if (!this.isDragging) return;
            this.isDragging = false;

            const delta = e.clientX - this.startX;
            if (Math.abs(delta) > SWIPE_THRESHOLD) {
                activeIndex = Math.max(0, Math.min(2, activeIndex + (delta < 0 ? 1 : -1)));
                updateSlides();
            }
        }

        function calculatePosition(index, state) {
            const config = slidesConfig[index];
            const baseTranslate = config.translateX;
            const translateY = (config.translateYInitial || -70) * Math.abs(index - (state + 1));

            if (state === 0) return { x: [2, 3].includes(index) ? config.width / 2 : config.width, y: translateY };
            if (state === 2) return { x: [1, 2].includes(index) ? -config.width / 2 : -config.width, y: translateY };
            return { x: baseTranslate, y: translateY };
        }

        function animateText(slide, isActive) {
            gsap.utils.toArray('.catalog-card p span', slide).forEach(line => {
                const p = line.parentElement;
                const dist = (p.clientWidth - line.offsetWidth) / 2;
                gsap.to(line, {
                    x: isActive ? dist : 0,
                    duration: ANIMATION_DURATION,
                    ease: 'power3.out',
                });
            });
        }

        function updateSlides() {
            coverflowSlides.forEach((slide, index) => {
                if (index < 1 || index > 3) return;

                const isActive = (index - 1) === activeIndex;
                const { x, y } = calculatePosition(index, activeIndex);
                const rotation = ROTATION_MAP[activeIndex][index];

                gsap.to(slide, {
                    x,
                    y,
                    z: isActive ? 0 : -40,
                    rotationY: rotation,
                    duration: ANIMATION_DURATION,
                    ease: 'power3.out',
                    overwrite: true,
                });

                animateText(slide, isActive);
                slide.classList.toggle('is-active', isActive);
            });
        }

        // Инициализация событий
        const events = [
            ['pointerdown', handlePointerDown],
            ['pointerup', handlePointerUp],
            ['pointercancel', handlePointerUp],
            ['pointerleave', handlePointerUp],
        ];

        events.forEach(([type, handler]) => coverflowSlider.addEventListener(type, handler));
        updateSlides();
    }

    handleReviewsSlide() {
        return {
            enter: () => {
                const mainSlider = this.sliders.main;
                mainSlider.disable();

                if (this.animations.reviews.wasAnimated) return;

                const container = this.slide.active.el;
                if (!container) return;

                // Инициализация слайдеров
                this.reviewSlide = this.reviewSlide || {
                    sliderInstances: [],
                    tweening: false,
                    touch: { startY: 0 },
                };

                this.reviewSlide.sliderElems = $.qsa('[data-slot="reviews-slider"]', container);

                // Сброс состояния при повторном входе
                this.reviewSlide.sliderInstances = [];

                this.reviewSlide.sliderElems.forEach((slider, index) => {
                    const slides = $.qsa('[data-slot="review-card"]', slider);
                    const instance = new Swiper(slider, {
                        slidesPerView: 'auto',
                        centeredSlides: true,
                        speed: 300,
                        roundLengths: true,
                        freeMode: { enabled: true, momentum: false },
                        initialSlide: index === 0 ? 0 : slides.length - 1,
                        allowTouchMove: false,
                        on: {
                            resize: swiper => !this.reviewSlide.tweening && this.updateReviewCardTransforms(swiper),
                        },
                    });
                    this.reviewSlide.sliderInstances.push(instance);
                });

                // Фикс для Safari
                this.handleReviewsScroll(1, 0, null);

                // Обработчики событий
                const handleEvent = {
                    wheel: e => {
                        e.preventDefault();

                        // Определяем событие тачпада по deltaMode и величине deltaY
                        const isTouchpad = e.deltaMode === 0; // 0 - пиксели, 1 - линии, 2 - страницы
                        const minDeltaThreshold = 15; // Порог для мелких дельт тачпада

                        // Игнорировать мелкие дельты от тачпада
                        if (isTouchpad && Math.abs(e.deltaY) < minDeltaThreshold) return;

                        this.handleReviewsScroll(e.deltaY, 0.3, e);
                    },
                    touchstart: e => {
                        this.reviewSlide.touch.startY = e.touches[0]?.clientY;
                    },
                    touchmove: e => {
                        const delta = e.touches[0]?.clientY - this.reviewSlide.touch.startY;
                        this.handleReviewsScroll(delta, 0.2, e);
                        this.reviewSlide.touch.startY = e.touches[0]?.clientY;
                    },
                };

                container.addEventListener('wheel', handleEvent.wheel);
                container.addEventListener('touchstart', handleEvent.touchstart);
                container.addEventListener('touchmove', handleEvent.touchmove);

                // Анимация фона
                const bg1 = $.qs('[data-slot="reviews-bg-1"]', container);
                const bg2 = $.qs('[data-slot="reviews-bg-2"]', container);
                if (bg1 && bg2) {
                    gsap.set([bg1, bg2], {
                        opacity: 0,
                    });
                    // gsap.to([bg1, bg2], {
                    //     opacity: 1,
                    //     duration: this.duration.long,
                    //     ease: 'power4.inOut',
                    //     onComplete: () => this.animations.reviews.wasAnimated = true,
                    // });
                }

                // Сохраняем ссылки для удаления событий
                this.reviewSlide.eventHandlers = handleEvent;
                this.animations.reviews.wasAnimated = true;
            },

            exit: () => {
                const container = this.slide.active.el;
                if (!container || !this.reviewSlide.eventHandlers) return;

                // Удаление обработчиков событий
                container.removeEventListener('wheel', this.reviewSlide.eventHandlers.wheel);
                container.removeEventListener('touchstart', this.reviewSlide.eventHandlers.touchstart);
                container.removeEventListener('touchmove', this.reviewSlide.eventHandlers.touchmove);

                this.sliders.main.enable();
                this.defaultExitAnimation();
            },
        };
    }

    handleReviewsScroll(deltaY, mult, event) {
        if (!this.reviewSlide?.sliderInstances?.[0]) return;

        // Добавляем проверку на тачпад и корректируем чувствительность
        if (event?.deltaMode === 0) {
            const touchpadSensitivity = 0.5; // Чувствительность для тачпада
            mult *= touchpadSensitivity;
        }

        event?.preventDefault();
        const touchReverse = event?.touches?.[0] ? -1 : 1;
        const direction = (deltaY > 0 ? 1 : -1) * touchReverse;
        const delta = direction * mult;

        const newProgress = this.reviewSlide.sliderInstances[0].progress + delta;
        const clampedProgress = Math.min(Math.max(newProgress, 0), 1);

        if ((this.reviewSlide.sliderInstances[0].isBeginning && direction === -1) || (this.reviewSlide.sliderInstances[0].isEnd && direction === 1)) {
            this.sliders.main.enable();
        } else {
            this.animateProgress(clampedProgress, direction);
        }
    }

    animateProgress(progress) {
        const { sliderInstances } = this.reviewSlide;
        const progressObj = { value: sliderInstances[0].progress };

        this.reviewSlide.tweening = true;

        gsap.to(progressObj, {
            value: progress,
            duration: 0.8,
            ease: 'power3.out',
            onUpdate: () => {
                sliderInstances[0].setProgress(progressObj.value);
                sliderInstances[1].setProgress(1 - progressObj.value);
                this.updateReviewCardTransforms(sliderInstances[0]);
                this.updateReviewCardTransforms(sliderInstances[1]);
                this.reviewSlide.isEnd = false;
            },
            onComplete: () => {
                this.reviewSlide.tweening = false;
                this.reviewSlide.isEnd = true;
            },
        });
    }

    updateReviewCardTransforms(swiper) {
        const containerRect = swiper.el.getBoundingClientRect();
        const containerCenter = containerRect.left + containerRect.width / 2;
        const scaleFactor = containerRect.width / 2560;

        swiper.slides.forEach(slide => {
            const card = $.qs('[data-slot="review-card"]', slide);
            if (!card) return;

            const slideRect = slide.getBoundingClientRect();
            const distance = (slideRect.left + slideRect.width / 2 - containerCenter) / containerRect.width;

            gsap.set(card, {
                y: Math.pow(distance, 2) * 300 * scaleFactor,
                rotation: distance * 15,
            });
        });
    }

    handleParallaxSlide() {
        return {
            enter: () => {
                this.sliders.main.disable();
                this.sliders.main.mousewheel.disable();

                // Находим блок для скролла и добавляем обработчик
                const scrollableBlock = $.qs('[data-scrollable]', this.slide.active.el);
                if (scrollableBlock) {
                    this.handleScrollableBlock(scrollableBlock);
                }
            },
            exit: () => {
                const scrollableBlock = $.qs('[data-scrollable]', this.slide.active.el);

                if (scrollableBlock) {
                    scrollableBlock.removeEventListener('wheel', this._scrollHandlers.wheelHandler);
                    scrollableBlock.removeEventListener('touchstart', this._scrollHandlers.touchStartHandler);
                    scrollableBlock.removeEventListener('touchmove', this._scrollHandlers.touchMoveHandler);
                    scrollableBlock.removeEventListener('touchend', this._scrollHandlers.touchEndHandler);
                }
            },
        };
    }

    // Кастомный метод для обработки скролла блока, т.к. свайпер отключает скролл
    handleScrollableBlock(element) {
        if (!this.hasEnded && !this.enterBack) element.scrollTop = 0;

        let startY = 0;
        let lastDeltaY = 0;
        let scrollAnimation = null;
        let lastScrollTop = 0;
        let currentDirection = null;

        const parallaxCardsElems = $.qsa('[data-slot="parallax-card"]', element);

        const parallaxCards = parallaxCardsElems.map(card => ({
            element: card,
            speed: parseFloat(card.dataset.parallaxSpeed) || 0.3,
            offset: parseFloat(card.dataset.parallaxOffset) || 0,
            mult: parseFloat(card.dataset.parallaxMult) || 1,
        }));

        const updateParallax = () => {
            const scrollTop = element.scrollTop;
            const maxScroll = element.scrollHeight - element.clientHeight;
            const baseProgress = maxScroll > 0 ? scrollTop / maxScroll : 0;

            parallaxCards.forEach(({ element: card, speed, offset, mult }) => {
                let adjustedProgress = baseProgress - offset;
                adjustedProgress = Math.max(0, Math.min(1, adjustedProgress));
                gsap.set(card, { y: adjustedProgress * speed * mult * -100 });
            });
        };

        const handleScrollEnd = (m) => {
            if (m === false) return;

            this.sliders.main.disable();
            this.hasEnded = true;

            lenis.start();

            this.$block.classList.remove('is-active');
        };

        const checkBoundaries = (scrollTop, direction) => {
            const maxScroll = element.scrollHeight - element.clientHeight;
            if (direction === 'down' && scrollTop >= maxScroll - 10) {
                handleScrollEnd(true);
                this.handleParallaxSlide().exit();
                lenis.scrollTo(window.scrollY + 400, {
                    duration: 1,
                    easing: e => Math.min(1, 1.001 - Math.pow(2, - 10 * e)),
                    lerp: 0.1,
                });
                return true;
            }
            if (direction === 'up' && scrollTop <= 1) {
                this.handleParallaxSlide().exit();
                this.sliders.main.slideTo(3);
                this.sliders.main.enable();
                this.sliders.main.mousewheel.enable();
                return true;
            }
            return false;
        };


        const animateScroll = (target, duration = 0.5) => {
            if (scrollAnimation) scrollAnimation.kill();

            scrollAnimation = gsap.to(element, {
                scrollTop: target,
                duration,
                ease: 'power2.out',
                onUpdate: () => {
                    const currentScroll = element.scrollTop;
                    currentDirection = currentScroll > lastScrollTop ? 'down' : 'up';
                    lastScrollTop = currentScroll;

                    updateParallax();

                    // Проверка границ во время анимации
                    if (checkBoundaries(currentScroll, currentDirection)) {
                        scrollAnimation.kill();
                    }
                },
                onComplete: () => {
                    // Финальная проверка после завершения анимации
                    checkBoundaries(element.scrollTop, currentDirection);
                    scrollAnimation = null;
                },
            });
        };

        const wheelHandler = e => {
            if (this.hasEnded || element.scrollHeight <= element.clientHeight) return;

            const isTouchpad = e.deltaMode === 0;
            const minDelta = isTouchpad ? 10 : 3;

            if (Math.abs(e.deltaY) < minDelta) return;

            e.preventDefault();
            e.stopPropagation();

            // Плавность для тачпада
            const directionMultiplier = isTouchpad ? 100 : 200;
            const direction = (e.deltaY > 0 ? 1 : -1) * directionMultiplier;

            animateScroll(Math.max(0, Math.min(
                element.scrollTop + direction,
                element.scrollHeight - element.clientHeight,
            )));
        };

        const touchStartHandler = e => {
            if (this.hasEnded) return;

            startY = e.touches[0]?.clientY;
            if (scrollAnimation) scrollAnimation.kill();
        };

        const touchMoveHandler = e => {
            if (this.hasEnded || element.scrollHeight <= element.clientHeight) return;

            e.preventDefault();
            e.stopPropagation();

            const delta = (startY - e.touches[0]?.clientY);
            startY = e.touches[0]?.clientY;
            lastDeltaY = delta;

            animateScroll(element.scrollTop + delta, 0.1);
        };

        const touchEndHandler = () => {
            if (this.hasEnded || !lastDeltaY) return;

            // Фильтрация микро-свайпов
            if (Math.abs(lastDeltaY) < 5) {
                lastDeltaY = 0;
                startY = 0;
                return;
            }

            const inertiaDelta = lastDeltaY * 15;
            animateScroll(Math.max(0, Math.min(element.scrollTop + inertiaDelta, element.scrollHeight - element.clientHeight)), 1);
            lastDeltaY = 0;
            startY = 0;
        };

        element.addEventListener('wheel', wheelHandler);
        element.addEventListener('touchstart', touchStartHandler);
        element.addEventListener('touchmove', touchMoveHandler, { passive: false });
        element.addEventListener('touchend', touchEndHandler);

        this._scrollHandlers = { wheelHandler, touchStartHandler, touchMoveHandler, touchEndHandler };
        this._updateParallax = updateParallax;
    }

    defaultEnterAnimation(el) {
        if (!el) return;

        return gsap.to(el,
            { opacity: 1, duration: this.duration.long, ease: this.ease, delay: 0.2 },
        );
    }

    defaultExitAnimation(el) {
        if (!el) return;

        return gsap.to(el,
            { opacity: 0, duration: this.duration.long, ease: this.ease },
        );
    }
}

function mainSlides() {
    const block = $.qs('[data-main-slides]');
    if (block) {
        const mainSlides = new MainSlides(block);
        window.mainSlides = mainSlides;
    }
}

export default mainSlides;
