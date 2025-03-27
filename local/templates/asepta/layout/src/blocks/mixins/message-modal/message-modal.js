import {open, close} from '../modal/modal';

// Функция для бэка
function renderMessageModal(data) {
    let linkHTML = data.link ? `<a href="${data.link.href}" class="message-modal__link btn"><span class="btn__text">${data.link.text}</span></a>` : '';
    const modal = document.createElement('section');
    modal.className = 'modal modal--message-modal modal--message';
    modal.setAttribute('data-modal', 'message-modal');

    if (data.hint)
        modal.innerHTML = `
            <div class="modal__container">
                <div class="modal__content">
                    <div class="message-modal">
                        <div class="message-modal__info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 16V12" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 8H12.01" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="message-modal__title">${data.title}</p>
                    </p>
                </div>      
            </div>
        `;
    else
        modal.innerHTML = `
            <button class="modal__overlay" type="button" data-modal-close="message-modal"></button>
            <div class="modal__container">
                <div class="modal__content">
                    <div class="message-modal">
                        <button class="btn--close message-modal__close u-center" type="button" data-modal-close="message-modal"></button>
                        <p class="message-modal__title">${data.title}</p>
                        <p class="message-modal__text">${data.text}</p>
                        ${linkHTML}
                    </p>
                </div>      
            </div>
        `;

    document.body.append(modal);

    open(modal, null, true);
    setTimeout(() => {
        if (modal) {
            close(modal, true);
        }
    }, 8000);
}

document.addEventListener('afterModalClose', e => {
    const modalName = e.detail.modalName;
    if (modalName === 'message-modal') {
        setTimeout(() => {
            $.qs(`[data-modal=${modalName}]`).remove();
        }, 300);
    }
});

window.renderMessageModal = renderMessageModal;

// Тест
// renderMessageModal({
//     title: 'Товар добавлен в корзину',
//     text: 'Оператор свяжется с вами в течение часа',
//     link: {
//         href: '#',
//         text: 'Перейти в корзину',
//     },
// });

// Hint
// renderMessageModal({
//     title: 'Новый пароль сохранён',
//     hint: true,
// });