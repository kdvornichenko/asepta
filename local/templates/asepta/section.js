'use strict';
class SectionPage
{
    wrapId = '';
    wrap = null;
    pageNavigationClass = '';
    showMoreClass = '';
    elementListClass = '';

    constructor(selectors)
    {
        this.wrapId = selectors.wrapId;
        this.pageNavigationClass = selectors.pageNavigationClass;
        this.showMoreClass = selectors.showMoreClass;
        this.elementListClass = selectors.elementListClass;
        this.orderSelectClass = selectors.orderSelectClass;
        this.wrap = document.getElementById(this.wrapId);

        if (this.wrap) {
            this.wrap.addEventListener('click', Tool.proxy(this.showMoreClickHandler, this));
        }

        this.orders = document.querySelectorAll(`.${this.orderSelectClass}`);
        if (this.orders) {
            for (let i = 0; i < this.orders.length; i++) {
                this.orders[i].addEventListener('change', Tool.proxy(this.orderChangeHandler, this));
            }
        }

        this.contents = document.querySelectorAll(`[data-reload-content]`);

        document.addEventListener('custom_section_filter_apply', Tool.proxy(function (event) {
            this.reload(event.detail.url);
        }, this));
    }

    showMoreClickHandler(event)
    {
        let showMoreButton = Tool.closest(event.target, `.${this.showMoreClass}`)
        if (showMoreButton) {
            event.preventDefault();
            event.stopPropagation();
            this.reload(showMoreButton.href ? showMoreButton.href : showMoreButton.dataset.href, true);
        }
    }

    orderChangeHandler(event)
    {
        this.reload(event.target.getAttribute('data-link'));
    }

    reload(url, more)
    {
        showLoader(this.wrap)
        let data = new FormData();
        data.append('ajax_request', 'Y');
        axios({
            url: url,
            method: 'post',
            params: {},
            data: data,
            timeout: 0,
            responseType: 'text',
        }).then(Tool.proxy(function (response) {
            this.reloadHandler(response.data, more);
            hideLoader(this.wrap)
        }, this));
    }

    reloadHandler(response, more)
    {
        let parser, html,
            wrap, link, content,
            elements, buttons, list, nav;

        parser = new DOMParser();
        html = parser.parseFromString(response, 'text/html');
        wrap = html.getElementById(this.wrapId);

        if (!!more) {
            list = this.wrap.querySelector(`.${this.elementListClass}`);
            nav = list.querySelector(`.${this.pageNavigationClass}`);
            if (nav) {
                nav.parentNode.removeChild(nav);
            }
            nav = this.wrap.querySelector(`.${this.pageNavigationClass}`);
            if (nav) {
                buttons = html.querySelector(`.${this.pageNavigationClass}`);
                if (buttons) {
                    nav.innerHTML = buttons.innerHTML;
                } else {
                    nav.parentNode.removeChild(nav);
                }
            }
            elements = html.querySelector(`.${this.elementListClass}`);
            if (elements) {
                list.insertAdjacentHTML('beforeend', elements.innerHTML);
            }
        } else if (wrap) {
            this.wrap.innerHTML = wrap.innerHTML;
            for (let i = 0; i < this.orders.length; i++) {
                link = html.getElementById(this.orders[i].id);
                if (link) {
                    this.orders[i].setAttribute('data-link', link.dataset.link);
                }
            }
            for (let j = 0; j < this.contents.length; j++) {
                content = html.getElementById(this.contents[j].id);
                if (content) {
                    this.contents[j].innerHTML = content.innerHTML;
                }
            }
        }

        if (wrap) {
            Tool.evalScripts(wrap);
        }

        document.dispatchEvent(new CustomEvent('custom_block_ajax_loaded', {detail: {wrap: this.wrapId}}));
    }
}
