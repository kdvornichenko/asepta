const header = $.qs('[data-header]');
const isMainPage = $.page('main').is;

const setHeaderHeight = () => {
    document.body.style.setProperty(
        '--header-height',
        `${header.offsetHeight}px`,
    );
};

const setHeaderState = () => {
    const scroll = window.scrollY;
    const isFixed = header.classList.contains('header--fixed');

    if (scroll > window.innerHeight / 2) {
        header.classList.add('header--small');
        if (isMainPage && !isFixed) {
            header.classList.add('header--hidden');
        }
    }
    else {
        header.classList.remove('header--small');
        isMainPage && header.classList.remove('header--hidden');
    }
};

window.addEventListener('scroll', () => {
    setHeaderHeight();
    setHeaderState();
});

window.addEventListener('DOMContentLoaded', () => {
    isMainPage && header.classList.add('is-main');

    setHeaderHeight();
    setHeaderState();
});

window.addEventListener('resize', () => {
    setHeaderHeight();
});
