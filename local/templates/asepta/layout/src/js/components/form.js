import IMask from 'imask';

export default class Form {
    constructor(elem) {
        this.$form = elem;
        this.isValid = true;
        this.init();
    }

    init() {
        this.$form.form = this;
        
        this.$form.addEventListener('click', e => {
            if (e.target.closest('[data-submit]')) {
                this.checkForm(e);
            }
        });

        this.$form.addEventListener('keydown', e => {
            if (e.code === 'Enter' && e.target.tagName === 'INPUT') {
                this.checkForm(e);
            }
        });

        this.$form.addEventListener('focus', e => {
            if (e.target.classList.contains('validate', 'error')) {
                e.target.classList.remove('error');
                this.removeError(e.target);
                if (!$.qsa('.error', this.$form).length) {
                    this.removeDisableBtn();
                }
            }
        }, true);

        this.$form.addEventListener('blur', e => {
            if (e.target.classList.contains('validate') && !e.target.value.trim()) {
                e.target.classList.add('error');
                this.setError(e.target, this.$form.dataset.formError);
                this.setDisableBtn();
            }
        }, true);

        this.$form.addEventListener('change', e => {
            if ((e.target.type === 'checkbox' || e.target.type === 'radio') && e.target.classList.contains('validate')) {
                if (e.target.checked) {
                    e.target.classList.remove('error');
                    if (!$.qsa('.error', this.$form).length) {
                        this.removeDisableBtn();
                    }
                }
                if (!e.target.checked) {
                    e.target.classList.add('error');
                    this.setDisableBtn();
                }
            }
        });

        $.qsa('[data-tel]', this.$form).forEach(el => {    
            IMask(el, {
                mask: '(000) 000-00-00',
            });
        });
    }

    checkForm(e) {
        this.isValid = true;
        this.validateForm();
        if (!this.isValid) {
            this.setDisableBtn();
            e.preventDefault();
        }
    }

    validateForm() {
        $.qsa('.validate', this.$form).forEach(input => {
            if (input.type === 'checkbox') {
                if (!input.checked) {
                    input.classList.add('error');
                    this.isValid = false;
                }
            } else {
                if (!input.value.trim()) {
                    input.classList.add('error');
                    this.isValid = false;
                    this.setError(input, this.$form.dataset.formError);
                } else if (input.type === 'email') {
                    const reg = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(input.value);
                    if (!reg) {
                        input.classList.add('error');
                        this.isValid = false;
                        this.setError(input, input.dataset.mailError);
                    }
                } else if (input.type === 'tel') {
                    if (input.value.trim().length !== 15) {
                        input.classList.add('error');
                        this.isValid = false;
                        this.setError(input, input.dataset.telError);
                    }
                } else if (input.type === 'password' && input.dataset.formPasswordRepeat !== undefined) {
                    let inputPassword = $.qs('[data-form-password-check]', this.$form);

                    if (inputPassword?.value === input.value) return;
                    
                    input.classList.add('error');
                    inputPassword?.classList.add('error');

                    this.isValid = false;
                    this.setError(input, input.dataset.passwordError);
                } else if (input.type === 'password') {
                    if (input.dataset.formPassword == undefined) return;
                    
                    let minLength = input.getAttribute('minlength');

                    const setLocalError = (dataOfError) => {
                        input.classList.add('error');
                        this.isValid = false;
                        this.setError(input, input.dataset[dataOfError]);
                    };

                    if (input.value.trim().length < minLength)
                        setLocalError('lengthError');
                    else if (!input.value.match(/[a-z]/i))
                        setLocalError('lettersError');
                    else if (!input.value.match(/[0-9]/i))
                        setLocalError('numbersError');

                    
                }
            }
        });
    }

    setDisableBtn() {
        $.qsa('[data-submit]', this.$form).forEach(btn => btn.setAttribute('disabled', 'disabled'));
    }

    removeDisableBtn() {
        $.qsa('[data-submit]', this.$form).forEach(btn => btn.removeAttribute('disabled'));
    }
  
    setError(input, err) {
        const errEl = input.closest('.form__input-wrapper') ? $.qs('.form__error', input.closest('.form__input-wrapper')) : null;
        if (errEl) {
            errEl.innerHTML = err || '';
        }
    }
  
    removeError(input) {
        const errEl = input.closest('.form__input-wrapper') ? $.qs('.form__error', input.closest('.form__input-wrapper')) : null;
        if (errEl) {
            errEl.innerHTML = '';
        }
    }
}
