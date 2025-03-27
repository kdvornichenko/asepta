// .select--hide-checked-option - для селекта со скрытой выбранной опцией
// Событие select-check при изменении значения

export default class Select {
    constructor(el) {
        this.$el = el;
        this.$btn = $.qs('.select__btn', this.$el);
        this.$btnText = $.qs('.select__btn-text', this.$el);
        this.$content = $.qs('.select__content', this.$el);
        this.$contentInner = $.qs('.select__content-inner', this.$el);
        this.$options = $.qsa('.select__option', this.$el);
        this.$resetBtn = $.qs('.select__reset', this.$el);
        this.placeholder = this.$btn.dataset.placeholder;
        this.isOpen = false;
        this.isChecked = false;
        this.init();
    }

    init() {
        document.addEventListener('click', this.clickHandler.bind(this));
        this.$el.addEventListener('change', this.changeHandler.bind(this));
    
        const selectedOption = $.qs('.select__option input:checked', this.$el);
        if (selectedOption) {
            this.selectOption(selectedOption);
        }

        $.dispatch({
            el: document,
            name: 'select:inited',
            detail: {
                el: this.$el,
                option: selectedOption,
            },
        });
        
        this.setSize();
        this.$el.select = this;
    }

    open() {
        this.$el.classList.add('select--open');
        this.isOpen = true;

        $.dispatch({
            el: document,
            name: 'select:open',
            detail: {
                el: this.$el,
            },
        });
    }

    close() {
        this.$el.classList.remove('select--open');
        this.isOpen = false;

        $.dispatch({
            el: document,
            name: 'select:close',
            detail: {
                el: this.$el,
            },
        });
    }

    clickHandler(e) {
        if (e.target === this.$el || this.$el.contains(e.target)) {
            if (e.target === this.$btn || this.$btn.contains(e.target)) {
                if (this.isOpen) {
                    this.close();
                } else {
                    this.open();
                }
            }
            if (this.$resetBtn && (e.target === this.$resetBtn || this.$resetBtn.contains(e.target))) {
                const checkedInput = $.qs('input:checked', this.$el);
                if (checkedInput) {
                    checkedInput.checked = false;
                    checkedInput.dispatchEvent(new Event('change', {bubbles: true}));
                }
            }
        } else {
            if (this.isOpen) {
                this.close();
            }
        }
    }

    changeHandler(e) {
        this.selectOption(e.target);

        $.dispatch({
            el: document,
            name: 'select:check',
            detail: {
                el: this.$el,
                option: e.target,
            },
        });
    }
  
    selectOption(input) {
        this.changeBtnText(input);
        this.isChecked = input.checked;
        if ($.qs('input:checked', this.$el)) {
            this.$el.classList.add('select--checked');
        } else {
            this.$el.classList.remove('select--checked');
        }

        this.close();
        this.setSize();
    }

    changeBtnText(target) {
        this.$btnText.innerHTML = target.checked ? target.dataset.name : this.placeholder;
    }

    setSize() {
        this.$content.style.setProperty(
            '--content-height',
            `${this.$contentInner.offsetHeight}px`,
        );
    }

    on(eventName, func) {
        this.$el.addEventListener(eventName, e => func(e));
    }
}
