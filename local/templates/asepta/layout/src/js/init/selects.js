import Select from '~/js/components/select';

window.addEventListener('load', () => {
    $.each('[data-select]', el => new Select(el));

    document.addEventListener('frontend:reload', e => {
        const wrap = e.detail.wrap;
        if (!wrap) return;
        $.qsa('[data-select]', wrap).forEach(el => new Select(el));
    });
    
    window.addEventListener('resize', () => $.each('[data-select]', el => el.select.setSize()));
});
