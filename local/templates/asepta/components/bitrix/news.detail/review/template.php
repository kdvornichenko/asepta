<?php

use Its\Library\Image\Resize;
use Bitrix\Main\Localization\Loc;
use Its\Library\Data\Declension;
use Bitrix\Main\Type\DateTime;
use Cki\Template;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>
<?php
if (!empty($arResult['PROPERTIES']['IMAGES']['VALUE'])) {
    ?>
    <section class="modal modal--review modal--center" data-modal="review" data-lenis-prevent>
        <button class="modal__overlay" type="button" data-modal-close="review"></button>
        <div class="modal__container">
            <div class="modal__content">
                <div class="modal-review">
                    <div class="modal-review__inner container">
                        <button class="modal-review__close" data-modal-close="review">
                            <svg class="i-cross">
                                <use xlink:href="#cross"></use>
                            </svg>
                        </button>
                        <div class="modal-review__gallery">
                            <div class="product-review-gallery" data-slider-wrapper>
                                <div class="swiper product-review-gallery__main" data-slider-body data-slider-ratio>
                                    <div class="swiper-wrapper">
                                        <?php
                                        foreach ($arResult['PROPERTIES']['IMAGES']['VALUE'] as $galleryItem) {
                                            $resize = new Resize((int)$galleryItem, [400, 400]);
                                            if ($resize->isSuccess()) {
                                                ?>
                                                <div class="swiper-slide product-review-gallery__main-slide">
                                                    <?php
                                                    echo $resize->getPictureTag([
                                                        'alt' => htmlspecialchars($arResult['NAME']),
                                                        'lazy' => 'true',
                                                        'img_class' => 'lazyload',
                                                    ]);
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        } ?>

                                    </div>
                                    <div class="product-review-gallery__navigation">
                                        <button class="btn btn--icon btn--white product-review-gallery__navigation-btn product-review-gallery__navigation-btn--prev" data-slider-prev>
                                            <svg class="i-arrow-right">
                                                <use xlink:href="#arrow-right"></use>
                                            </svg>
                                        </button>
                                        <button class="btn btn--icon btn--white product-review-gallery__navigation-btn" data-slider-next>
                                            <svg class="i-arrow-right">
                                                <use xlink:href="#arrow-right"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="swiper product-review-gallery__thumbs" data-slider-thumbs>
                                    <div class="swiper-wrapper product-review-gallery__thumbs-wrapper">
                                        <?php
                                        foreach ($arResult['PROPERTIES']['IMAGES']['VALUE'] as $galleryItemTrumb) {
                                            $resizeTrumb = new Resize((int)$galleryItemTrumb, [400, 400]);
                                            if ($resizeTrumb->isSuccess()) {
                                                ?>
                                                <div class="swiper-slide product-review-gallery__thumbs-slide">
                                                    <?php
                                                    echo $resizeTrumb->getPictureTag([
                                                        'alt' => htmlspecialchars($arResult['NAME']),
                                                        'lazy' => 'true',
                                                        'img_class' => 'lazyload',
                                                    ]);
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-review__main">
                            <div class="modal-review__main-title">
                                <p><?=Loc::getMessage('REVIEW_DETAIL_MODAL_MAIN_TITLE')?></p>
                            </div>
                            <div class="modal-review__main-head">
                                <div class="modal-review__main-info">
                                    <p><?= $arResult['NAME'] ?></p>
                                    <span><?=(new DateTime($arResult['DATE_ACTIVE_FROM']))->format('d.m.Y')?></span>
                                </div>
                                <div class="modal-review__main-rating">
                                    <?php
                                    for ($i = 1; $i <= $arResult['PROPERTIES']['RATING']['VALUE']; $i++) {
                                        ?>
                                        <div class="modal-review__main-rating-item">
                                            <svg class="i-tooth">
                                                <use xlink:href="#tooth"></use>
                                            </svg>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <p><?= $arResult['PREVIEW_TEXT'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
} else {
    ?>
    <section class="modal modal--review-info modal--center" data-modal="review-info" data-lenis-prevent>
        <button class="modal__overlay" type="button" data-modal-close="review-info"></button>
        <div class="modal__container">
            <div class="modal__content">
                <div class="modal-review-info">
                    <div class="modal-review-info__inner container">
                        <button class="modal-review__close" data-modal-close="review-info">
                            <svg class="i-cross">
                                <use xlink:href="#cross"></use>
                            </svg>
                        </button>
                        <div class="modal-review-info__main-title">
                            <p><?=Loc::getMessage('REVIEW_DETAIL_MODAL_MAIN_TITLE')?></p>
                        </div>
                        <div class="modal-review-info__main-head">
                            <div class="modal-review-info__main-info">
                                <p><?= $arResult['NAME'] ?></p>
                                <span><?=(new DateTime($arResult['DATE_ACTIVE_FROM']))->format('d.m.Y')?></span>
                            </div>
                            <div class="modal-review-info__main-rating">
                                <?php
                                for ($i = 1; $i <= $arResult['PROPERTIES']['RATING']['VALUE']; $i++) {
                                    ?>
                                    <div class="modal-review-info__main-rating-item">
                                        <svg class="i-tooth">
                                            <use xlink:href="#tooth"></use>
                                        </svg>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <p><?= $arResult['PREVIEW_TEXT'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
