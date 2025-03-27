export class ActiveInner {
    constructor(el) {
        this.$element = el;
        this.$wrapper = $.qs(el.dataset.activeInner);
        this.rate = +el.dataset.activeInnerRate || null;
        this.init();
    }

    init() {
        window.addEventListener('scroll', () => {
            this.calcDest();
        });

        this.calcDest();
    }

    calcDest() {
        const scrollY = window.scrollY,
            wrapperTop = this.$wrapper.offsetTop,
            wrapperHeight = this.$wrapper.getBoundingClientRect().height,
            screenHeight = window.innerHeight;

        this.toggleStateElement(scrollY >= wrapperTop - screenHeight / 2 + this.rate && 
            scrollY < wrapperTop + wrapperHeight - screenHeight + this.rate);
    }

    toggleStateElement(isActive) {
        if (isActive)
            this.$element?.classList.add('active-inner');
        else
            this.$element?.classList.remove('active-inner');
    }
}