import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export class Parallax {
    constructor(el) {
        this.$object = el;
        this.data = this.$object.dataset.parallax;
        this.multiplier = el.dataset.parallaxMultiplier ? Number(el.dataset.parallaxMultiplier) : 1;
        this.trigger = $.qs(el.dataset.parallaxTrigger);
        this.start = el.dataset.parallaxStart;
        this.end = el.dataset.parallaxEnd;
        this.markers = el.dataset.markers || false;
        this.translateX = el.dataset.parallaxTranslatex;
        this.init();
    }

    init() {
        gsap.registerPlugin(ScrollTrigger);

        let data = this.data?.split(' ');

        data?.forEach(animName => {
            /* eslint-disable */
            switch (animName) {
                case 'slideBottom':
                    this.slideBottom(this.$object);
                    break;
                case 'slideTop':
                    this.slideTop(this.$object);
                    break;
                case 'fadeIn':
                    this.fadeIn(this.$object);
                    break;
                case 'slideLeft':
                    this.slideLeft(this.$object);
                    break;

                default:
                    break;
            }
            /* eslint-enable*/
        });
    }

    slideBottom(obj) {
        const multiplier = this.multiplier;
        const start = this.start;
        const end = this.end;
        const markers = Boolean(this.markers);

        // ScrollTrigger.matchMedia({
        //     '(min-width: 767px)': function () {
        gsap.to(obj, {
            y: 100 * multiplier,
            top: 0,
            translateY: 0,
            ease: 'none',
            opacity: 1,
            scrollTrigger: {
                trigger: this.trigger || obj,
                scrub: 2,
                start: start ? start : 'top-=200 top',
                end: end ? end : 'bottom top',
                invalidateOnRefresh: true,
                markers: markers,
            },
        });
        //     },
        // });
    }

    slideTop(obj) {
        const multiplier = this.multiplier;
        const start = this.start;
        const end = this.end;
        const markers = Boolean(this.markers);
        const objParent = obj.closest('[data-parallax-parent]');
        // ScrollTrigger.matchMedia({
        //     '(min-width: 767px)': function () {
        gsap.to(obj, {
            y: '20%',
            translateY: 0,
            ease: 'none',
            opacity: 1,
            scrollTrigger: {
                trigger: this.trigger || obj,
                scrub: 2 * multiplier,
                start: () => {
                    if (start) {
                        if (start.includes('parent')) {
                            if (!objParent) return;
                            else {
                                return `-=${objParent.clientHeight * 0.8}px bottom`;
                            }
                        } else {
                            return start;
                        }
                    } else {
                        return 'top bottom';
                    }
                },
                end: () => {
                    if (end) {
                        if (end.includes('parent')) {
                            if (!objParent) return;
                            else {
                                return '20% bottom';
                            }
                        } else {
                            return end;
                        }
                    } else {
                        return 'bottom bottom';
                    }
                },
                invalidateOnRefresh: true,
                markers: markers,
            },
        });
        //     },
        // });
    }

    fadeIn(obj) {
        const multiplier = this.multiplier;
        const markers = Boolean(this.markers);

        // ScrollTrigger.matchMedia({
        //     '(min-width: 767px)': function () {
        gsap.to(obj, {
            ease: 'none',
            opacity: 1,
            scrollTrigger: {
                trigger: this.trigger || obj,
                scrub: 2 * multiplier,
                start: 'top bottom',
                end: 'bottom bottom',
                invalidateOnRefresh: true,
                markers: markers,
            },
        });
        //     },
        // });
    }

    slideLeft(obj) {
        const multiplier = this.multiplier;
        const start = this.start;
        const end = this.end;
        const translateX = this.translateX;
        const markers = Boolean(this.markers);

        // ScrollTrigger.matchMedia({
        //     '(min-width: 767px)': function () {
        gsap.to(obj, {
            ease: 'none',
            left: 0,
            translateX: translateX ? translateX : '0',
            scrollTrigger: {
                trigger: this.trigger || obj,
                scrub: 2 * multiplier,
                start: start ? start : 'top bottom',
                end: end ? end : 'bottom bottom',
                invalidateOnRefresh: true,
                markers: markers,
            },
        });
        //     },
        // });
    }
}
