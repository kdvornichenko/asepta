export class ReviewItem {
    constructor(el) {
        this.$review = el;
        this.$text = $.qs('[data-review-item-text]', el);
        this.$buttonReadMore = $.qs('.review-item__read-more', el);

        this.init();
    }
    
    init() {
        window.addEventListener('resize', () => {
            this.setStateButton();
        });
        
        this.setStateButton();
    }

    setStateButton() {
        const showButton = this.checkTextHeight();

        if (showButton)
            this.$buttonReadMore.classList.remove('disabled');
        else
            this.$buttonReadMore.classList.add('disabled');
    }

    checkTextHeight() {
        return this.$text.scrollHeight > this.$text.clientHeight;
    }
}