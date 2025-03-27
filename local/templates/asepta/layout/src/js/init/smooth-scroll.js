import Lenis from 'lenis';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export const lenis = new Lenis({
    duration: 0.8,
});

window.lenis = lenis;

function raf(time) {
    lenis.raf(time);
    ScrollTrigger.update();
    requestAnimationFrame(raf);
}

export const stopScroll = () => {
    lenis.stop();
};

export const enableScroll = () => {
    lenis.start();
};

export const scrollTo = (el) => {
    lenis.scrollTo(el);
};

requestAnimationFrame(raf);
