export class ScrollToBlock {
    constructor(el) {
        this.$block = el;
        this.$offset = +el.dataset.offset || 0;

        this.init();
    }

    init() {
        window.addEventListener('scroll', () => {
            this.checkPosition();
        });

        this.checkPosition();
    }

    checkPosition() {
        const scroll = window.scrollY,
            windowHeight = window.innerHeight;

        const { top } = this.$block.getBoundingClientRect();
        const blockOffsetTop = windowHeight / 2 + top + this.$offset;

        if (scroll > blockOffsetTop && !this.$block.classList.contains('scroll-to-block-finish')) {
            this.$block.classList.add('scroll-to-block-finish');

            $.dispatch({
                el: this.$block,
                name: 'scrollToBlock',
                detail: { scroll },
            });
        }
    }
}