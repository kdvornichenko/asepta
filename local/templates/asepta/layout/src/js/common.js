import '~/assets/sass/main.sass';
import '~/assets/sprite/';
import '~/js/init/axios';
import '~/js/init/css-props';
import '~/js/init/forms';
import '~/js/init/tabs';
import '~/js/init/accordions';
import '~/js/init/selects';
import '~/js/init/reload';
import '~/js/init/console-copyright';
import '~/js/init/full-page-slider';
import '~/js/init/loop-line-slider';
import '~/js/init/mobile-full-slider';
import '~/js/init/experts-slider';
import '~/js/init/smooth-scroll';
import '~/js/init/scroll-to-block';
import '~/js/init/parallax';
import '~/js/init/scroll-slider';
import '~/js/init/product-gallery';
import '~/js/init/active-inner';
import '~/js/init/reviews-slider';
import '~/js/init/review-item';
import '~/js/init/filters';
import '~/blocks/mixins/loader/loader';
import '~/blocks/mixins/modal/modal';
import '~/blocks/mixins/message-modal/message-modal';
import '~/blocks/mixins/video/video';
import '~/blocks/mixins/header/header';
import '~/blocks/includes/main-bestsellers/main-bestsellers';
import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import buy from '~/blocks/includes/buy-body/buy';
import articleBottom from '~/blocks/includes/article-bottom/article-bottom';
import modalMenuInit from '~/blocks/includes/modal-menu/modal-menu';
import hideAllReviewsBtn from '~/blocks/includes/product-reviews/product-reviews';
import closeModalOnDrag from '~/blocks/includes/modal-buy-product/modal-buy-product';
import mainSlides from '~/blocks/includes/main-slides/main-slides';
import initMainBestsellersSlider from '~/js/init/main-bestsellers-slider';

// Немедленная инициализация
const immediateInitFunctions = [modalMenuInit];
immediateInitFunctions.forEach(initFunction);

// Инициализация функций для конкретной страницы
const onPageFunctions = [
    { page: 'main', funcs: [mainSlides, initMainBestsellersSlider] },
    { page: 'buy', funcs: [buy] },
    { page: 'article', funcs: [articleBottom] },
    { page: 'product-detail', funcs: [hideAllReviewsBtn, closeModalOnDrag] },
];

onPageFunctions.forEach(obj => {
    const page = $.qs(`[data-page="${obj.page}"]`);

    if (!page || obj.funcs?.length === 0) return;

    obj.funcs.forEach(func => initFunction(func, page));
});

// Функция для инициализации с обработкой ошибок
function initFunction(func, page) {
    try {
        func(page);
    } catch (error) {
        console.error(`Ошибка при инициализации функции "${func.name}":`, error);
    }
}
