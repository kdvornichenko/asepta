<?php

use Its\Library\Image\Resize;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;

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

if (empty($arResult['ITEMS'])) {
    return;
}
?>
    <div class="product-reviews">
        <div class="container">
            <h2> <?=Loc::getMessage('REVIEWS_LIST_TITLE')?> </h2>
        </div>
        <div class="swiper product-reviews__slider container" data-slider="reviews">
            <div class="product-reviews__navigation container">
                <button class="product-reviews__navigation-btn product-reviews__navigation-btn--prev" data-slider-prev>
                    <svg class="i-arrow-right">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                    <div class="product-reviews__navigation-btn--mob">
                        <svg class="i-arrow-right-small">
                            <use xlink:href="#arrow-right-small"></use>
                        </svg>
                    </div>
                </button>
                <button class="product-reviews__navigation-btn" data-slider-next>
                    <svg class="i-arrow-right">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                    <div class="product-reviews__navigation-btn--mob">
                        <svg class="i-arrow-right-small">
                            <use xlink:href="#arrow-right-small"></use>
                        </svg>
                    </div>
                </button>
            </div>
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['ITEMS'] as $index => $itemData) {
                    ?>
                <div class="swiper-slide product-reviews__slider-item"
                     data-modal-url="/local/ajax/review.php?id=<?=$itemData['ID']?>"
                     data-modal-open="review">
                    <div class="review-item" data-review-item>
                        <div class="review-item__head">
                            <div class="review-item__main">
                                <div class="review-item__main-info">
                                    <p><?= $itemData['NAME'] ?></p>
                                    <span><?=(new DateTime($itemData['DATE_ACTIVE_FROM']))->format('d.m.Y')?></span>
                                </div>
                            </div>
                            <div class="review-item__rating">
                             <?php
                                for ($i = 1; $i <= $itemData['PROPERTIES']['RATING']['VALUE']; $i++) {
                                    ?>
                                <div class="review-item__rating-item">
                                    <svg class="i-tooth">
                                        <use xlink:href="#tooth"></use>
                                    </svg>
                                </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <p data-review-item-text> <?= $itemData['PREVIEW_TEXT'] ?></p>
                        <div class="review-item__read-more"><?=Loc::getMessage('REVIEWS_LIST_READ_MORE')?></div>
                        <div class="review-item__gallery">
                           <?php
                            foreach ($itemData['PROPERTIES']['IMAGES']['VALUE'] as $galleryItem) {
                                $resize = new Resize((int)$galleryItem, [400, 400]);
                                if ($resize->isSuccess()) {
                                    ?>
                                    <div class="review-item__gallery-item">
                                    <?php
                                    echo $resize->getPictureTag([
                                    'alt' => htmlspecialchars($itemData['NAME']),
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
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="product-reviews__btn container">
            <a class="btn btn--outline" href="/reviews/">
                <span class="btn__text"><?=Loc::getMessage('REVIEWS_LIST_VIEW_ALL')?></span>
            </a>
        </div>
    </div>
