import { Parallax } from '~/js/components/parallax';

window.addEventListener('load', () => {
    const objects = $.qsa('[data-parallax]');

    objects?.forEach(obj => {
        setTimeout(() => {
            new Parallax(obj);
        }, 300);
    });
});
