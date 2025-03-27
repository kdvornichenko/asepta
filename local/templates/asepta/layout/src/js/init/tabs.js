document.addEventListener('click', function(e) {
    const tab = e.target.closest('[data-tab-link]');
    if (!tab) return;
    const id = tab.dataset.tab;
    const tabName = tab.dataset.tabLink;
    const content = $.qs(`[data-tab-content='${tabName}'][data-tab='${id}']`);
    if (content) {
        const activeContent = $.qs(`[data-tab-content='${tabName}'].is-active`);
        const activeTab = $.qs(`[data-tab-link='${tabName}'].is-active`);
        if (activeContent) {
            $.dispatch({
                el: document,
                name: 'tabs:close',
                detail: { id, name: tabName, content: activeContent},
            });
            activeContent.classList.remove('is-active');
        }
        if (activeTab) {
            activeTab.classList.remove('is-active');
        }
        tab.classList.add('is-active');
        content.classList.add('is-active');

        $.dispatch({
            el: document,
            name: 'tabs:open',
            detail: { id, name: tabName, content},
        });
    }
});
