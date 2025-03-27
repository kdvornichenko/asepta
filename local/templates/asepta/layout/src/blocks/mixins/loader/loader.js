function showLoader(target) {
    const loaderHTML = '<div class="loader"><div class="lds-ellipsis"><span></span><span></span><span></span></div></div>';
    if (getComputedStyle(target).position === 'static') {
        target.setAttribute('style', 'position: relative');
    }
    target.insertAdjacentHTML('beforeend', loaderHTML);
    target.classList.add('is-loading');
}

function hideLoader() {
    const target = $.qs('.is-loading');
    if (target) {
        target.classList.remove('is-loading');
        setTimeout(() => {
            if ($.qs('.loader')) {
                $.qs('.loader').remove();
            }
        }, 300);
    }
}

window.showLoader = showLoader;
window.hideLoader = hideLoader;

// Тест
// showLoader(document.body);
// setTimeout(() => {
//     hideLoader();
// }, 2000);
