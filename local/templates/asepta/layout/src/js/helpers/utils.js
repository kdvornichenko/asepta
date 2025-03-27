export const siblings = el =>
    [...el.parentElement.children].filter(c => c !== el);

export const nodeIndex = el => [...el.parentNode.children].indexOf(el);

export const qs = (selector, ctx = document) => ctx.querySelector(selector);

export const qsa = (selector, ctx = document) =>
    Array.from(ctx.querySelectorAll(selector));

export const each = (selector, cb) => {
    const elements = qsa(selector);

    if (elements.length <= 0) return false;

    elements.forEach((el, i) => {
        cb(el, i);
    });
};

export const delegate = (selector, resolve, reject, ev = 'click') => {
    document.addEventListener(
        ev,
        e => {
            const el = e.target.closest(selector);

            if (el) {
                resolve(e, el);
            } else if (reject) {
                reject(e);
            }
        },
        false,
    );
};

export const dispatch = (
    { el, name, detail } = { el: document, name: '', detail: null },
) => {
    if (!name) throw new Error('Event name not set');

    if (detail) {
        el.dispatchEvent(new CustomEvent(name, { detail }));
    } else {
        el.dispatchEvent(new Event(name));
    }
};

export const debounce = (func, wait, immediate) => {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        const later = () => {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

export const throttle = (fn, throttleTime) => {
    let start = -Infinity;
    let cachedResult;

    return function () {
        const end = Date.now();

        if (end - start >= throttleTime) {
            start = end;
            cachedResult = fn.apply(this, arguments);
        }

        return cachedResult;
    };
};

export const computedStyle = (element, style) => {
    return +window.getComputedStyle(element, null).getPropertyValue(style).slice(0, -2);
};

export const page = (name) => {
    const elem = $.qs(`[data-page="${name}"]`);
    const is = Boolean(elem);

    return { elem, is };
};