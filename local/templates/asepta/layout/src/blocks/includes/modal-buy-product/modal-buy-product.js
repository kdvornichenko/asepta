function closeModalOnDrag() {
    document.addEventListener('afterModalOpen', e => {
        if (e.detail.modalName === 'buy-product') {

            const modal = e.detail.modalElem;
            console.log(modal, e.detail);
            let startY = 0;
            let endY = 0;
            let isSwiping = false;

            modal.addEventListener('touchstart', (e) => {
                startY = e.touches[0].clientY;
                isSwiping = true;
            });

            modal.addEventListener('touchmove', (e) => {
                if (!isSwiping) return;
                endY = e.touches[0].clientY;
            });

            modal.addEventListener('touchend', () => {
                isSwiping = false;
                if (startY && endY && endY - startY > 50) {
                    window.closeModal(e.detail.modalElem, {});
                }
            });
        }

    });

}

export default closeModalOnDrag;
