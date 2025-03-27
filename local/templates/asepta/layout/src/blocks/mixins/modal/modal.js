import scroll from '~/js/helpers/stop-scroll';

const onEscape = e => {
    if (e.keyCode === 27) {
        const el = $.qs('.modal--active');

        if (!el) return false;

        const { modal } = el.dataset;
        close(el, modal);
    }
};

const haveOtherACtiveModals = () => {
    const body = $.qs('body'),
        allClasses = body.classList.value.split(' ');

    const activeModals = allClasses.filter(name => {
        const splitClass = name.split('-');
        return splitClass[0] == 'modal' && splitClass?.at(-1) == 'active';
    });

    return !!activeModals.length;
};

document.addEventListener('click', e => {
    // Load
    if (e.target.closest('[data-modal-url]')) {
        const el = e.target.closest('[data-modal-url]'),
            breakpoint = +el.dataset.modalBreakpoint;

        if (breakpoint && window.innerWidth > breakpoint) return;

        const modal = $.qs(`[data-modal="${el.dataset.modalReload}"]`);
        if (modal) modal.remove();

        load(el.dataset.modalUrl)
            .then(() => {
                if (!el.hasAttribute('data-modal-reload')) {
                    $.each(`[data-modal-url="${el.dataset.modalUrl}"]`, btn => btn.removeAttribute('data-modal-url'));
                }
            });
    }

    // Open
    if (e.target.closest('[data-modal-open]') && !e.target.closest('[data-modal-url]')) {
        const el = e.target.closest('[data-modal-open]'),
            breakpoint = +el.dataset.modalBreakpoint;

        if (breakpoint && window.innerWidth > breakpoint) return;

        const modal = $.qs(`[data-modal="${el.dataset.modalOpen}"]`);
        if (!modal) return;
        if (modal.classList.contains('modal--active')) {
            close(modal);
        } else {
            open(modal);
        }
    }

    // Close
    if (e.target.closest('[data-modal-close]')) {
        const el = e.target.closest('[data-modal-close]');
        const modal = $.qs(`[data-modal="${el.dataset.modalClose}"]`);
        if (!modal) return false;

        if (modal.hasAttribute('data-message-modal')) {
            close(modal, null, true);
        } else {
            close(modal);
        }
    }
});

export function load(url, ctx, isMessageModal = false) {
    return fetch(url)
        .then((response) => response.text())
        .then((html) => {
            const modal = document.createElement('div');
            modal.innerHTML = html;
            const trueModal = $.qs('section', modal);
            const existingModal = $.qs(`[data-modal="${trueModal.dataset.modal}"]`);
            if (existingModal) existingModal.remove();

            $.qs('.js-modals').appendChild(trueModal);

            return { modalElem: trueModal, modalWidth: trueModal.offsetWidth };
            // Передаем ширину trueModal.offsetWidth, чтобы последующий вызов then срабатывал после вычислений размеров и модалка открывалась с анимацией
        }).then(props => {
            const trueModal = props.modalElem;

            open(trueModal, ctx, isMessageModal);

            $.dispatch({
                el: document,
                name: 'modalLoaded',
                detail: { modalName: trueModal.dataset.modal, modalElem: trueModal, ctx },
            });
        });
}

export function open(el, ctx, isMessageModal = false) {
    closeActiveModals();

    const modalName = el.dataset.modal;
    const body = $.qs('body');

    body.classList.add(`modal-${modalName}-active`);

    $.dispatch({
        el: document,
        name: 'beforeModalOpen',
        detail: { modalName, modalElem: el, ctx },
    });

    !isMessageModal && scroll.disable(el);

    el.classList.add('modal--active');
    window.addEventListener('keydown', onEscape);

    $.dispatch({
        el: document,
        name: 'afterModalOpen',
        detail: { modalName, modalElem: el, ctx },
    });
}

export function close(el, ctx, isMessageModal = false) {
    const modalName = el.dataset.modal;
    const body = $.qs('body');

    body.classList.remove(`modal-${modalName}-active`);

    $.dispatch({
        el: document,
        name: 'beforeModalClose',
        detail: { modalName, modalElem: el, ctx },
    });

    (!isMessageModal && !haveOtherACtiveModals()) && scroll.enable(el);

    el.classList.remove('modal--active');
    window.removeEventListener('keydown', onEscape);

    $.dispatch({
        el: document,
        name: 'afterModalClose',
        detail: { modalName, modalElem: el, ctx },
    });
}

export function closeActiveModals() {
    const activeModals = $.qsa('.modal--active');
    if (!activeModals) return;
    activeModals.forEach(modal => {
        const modalName = modal.dataset.modal;
        close(modal);
        $.qs('body').classList.remove(`modal-${modalName}-active`);
    });
}

window.openModal = function (name, el, url) {
    if (el) {
        open(el);
    }
    if (!el && url) {
        const modal = $.qs(`[data-modal="${name}"]`);
        if (modal) modal.remove();
        load(url);
    }
};

window.closeModal = close;
