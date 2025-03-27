class BestsellerProduct {
    constructor(el) {
        this.$product = el;

        this.init();
    }

    init() {
        window.addEventListener('resize', () => { this.calcInfoHeight(); });

        this.calcInfoHeight();
    }

    calcInfoHeight() {
        let summ = 0;
        const infoBlock = $.qs('.product-card__info', this.$product);

        $.qsa('p', infoBlock)?.forEach(child => {
            summ += child.offsetHeight;
        });

        summ += +window.getComputedStyle(infoBlock, null).getPropertyValue('padding-bottom').slice(0, -2); // Get 'padding-bottom' and plus to summ



        this.$product.style.setProperty(
            '--bestseller-info-height',
            `${summ}px`,
        );
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const allProducts = $.qsa('[data-bestseller-item]');
    if (allProducts.length < 5) {
        if ($.qs('.main-bestsellers__navigation')) {
            $.qs('.main-bestsellers__navigation').classList.add('is-hidden');
        }

    }
    allProducts?.forEach(product => {
        new BestsellerProduct(product);
    });
});
