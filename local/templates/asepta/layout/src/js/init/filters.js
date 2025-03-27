import { Filters } from '~/js/components/filters';

function initFilters(filter) {
    new Filters(filter);
}

$.each('[data-filters]', form => initFilters(form));

document.addEventListener('frontend:reload', e => {
    const wrap = e.detail.wrap;
    if (!wrap) return;
    const filters = $.qsa('[data-filters]', wrap);
    filters.forEach(filter => initFilters(filter));
});

