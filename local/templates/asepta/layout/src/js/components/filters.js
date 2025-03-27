export class Filters {
    constructor(el) {
        this.$filtersForm = el;
        this.allInputs = $.qsa('input[type=checkbox]', el);
        this.btns = $.qsa('[data-modal-open=filters');
        this.$resetBtn = $.qs('[data-reset-filters]', el);
        this.$applyBtn = $.qs('[data-apply-filters]');
        this.countActive = 0;

        this.init();
    }

    init() {
        this.$resetBtn?.addEventListener('click', this.clearAll.bind(this));

        this.$filtersForm.addEventListener('change', () => {
            this.countActive = 0;

            this.allInputs?.forEach(input => {
                input.checked && this.countActive++;
            });

            this.setBtnSize();
        });

        this.initCheckedInputs();
    }

    initCheckedInputs() {
        this.countActive = 0;

        this.allInputs?.forEach(input => {
            input.checked && this.countActive++;
        });

        this.setBtnSize();
    }

    setBtnSize() {
        const countElements = [...this.btns, this.$applyBtn];

        countElements?.forEach(btn => {
            const spanOld = $.qs('.count', btn);
            spanOld?.remove();

            if (this.countActive === 0) return;

            let spanEl = document.createElement('span');
            spanEl.classList.add('count');
            spanEl.innerHTML = this.countActive;

            btn.append(spanEl);
        });
    }

    clearAll() {
        const allInputs = this.allInputs;

        allInputs?.forEach(input => {
            input.checked = false;
        });

        this.countActive = 0;

        $.dispatch({
            el: allInputs[0],
            name: 'change',
            detail: { el: this.$filtersForm},
        });

        $.dispatch({
            el: this.$filtersForm,
            name: 'change',
            detail: { el: this.$filtersForm},
        });
    }
}
