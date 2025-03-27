import Form from '~/js/components/form';

$.each('[data-form]', form => initForm(form));

document.addEventListener('frontend:reload', e => {
    const wrap = e.detail.wrap;
    if (!wrap) return;
    const forms = $.qsa('[data-form]', wrap);
    forms.forEach(form => initForm(form));
});

function initForm(form) {
    new Form(form);
}
