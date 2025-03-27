import { ActiveInner } from '~/js/components/active-inner';

const init = (element) => {
    new ActiveInner(element);
};

window.addEventListener('load', () => {
    $.each('[data-active-inner]', element => init(element));
});