
function modalMenuInit() {
    document.addEventListener('modalLoaded', (e) => modalMenu(e));
}

function modalMenu(e) {
    if (e.detail.modalName !== 'menu') return;

    const modalElem = e.detail.modalElem;
    const modalContent = $.qs('.modal__content', modalElem);

    function modalHeight() {
        modalElem.style.removeProperty('--modal-menu-height');
        if (window.matchMedia('(min-width: 501px)').matches) {
            modalElem.style.setProperty('--modal-menu-height', `${modalContent.offsetHeight + 10}px`);
        }
    }

    window.addEventListener('resize', $.debounce(() => modalHeight(), 300));

    modalHeight();

    window.setMenuModalHeight = modalHeight;
}

export default modalMenuInit;