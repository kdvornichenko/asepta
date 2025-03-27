document.addEventListener('modalLoaded', e => {
    const modal = $.qs(`[data-modal="${e.detail.modalName}"]`);
    $.dispatch({
        el: document,
        name: 'frontend:reload',
        detail: { wrap: modal },
    });
});
