<?php

use Its\Library\Image\Resize;
use Bitrix\Main\Localization\Loc;

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
<div class="main-bestsellers">
    <div class="container">
        <h2><?= Loc::getMessage('BESTSELLER_PRODUCTS_TITLE') ?></h2>
    </div>
    <div class="splide main-bestsellers__slider container" data-slider="main-bestseller" data-loop>
        <div class="splide__track">
            <div class="splide__list main-bestsellers__wrapper">
                <?php
                foreach ($arResult['ITEMS'] as $key => $itemData) {
                    $resize = new Resize((int)$itemData['~PREVIEW_PICTURE'], [840, 620], BX_RESIZE_IMAGE_PROPORTIONAL);
                    ?>
                    <div class="splide__slide main-bestsellers__slide" data-bestseller-item>
                        <a class="product-card" href="<?= $itemData['DETAIL_PAGE_URL'] ?>" data-parallax="slideTop">
                            <div class="product-card__image">
                                <?= $resize->getPictureTag([
                                    'alt' => htmlspecialchars($itemData['NAME']),
                                ]) ?>
                            </div>
                            <div class="product-card__info">
                                <p><?= $itemData['PROPERTIES']['GREY_TITLE']['VALUE'] ?></p>
                                <p><?= $itemData['PROPERTIES']['BLACK_TITLE']['VALUE'] ?></p>
                            </div>
                            <button class="btn btn--icon btn--icon-big">
                                <svg class="i-arrow-up-right">
                                    <use xlink:href="#arrow-up-right"></use>
                                </svg>
                            </button>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="splide__arrows"></div>
        <div class="main-bestsellers__navigation">
            <button class="splide__arrow splide__arrow--prev" data-slider-prev>
                <svg class="i-arrow-right">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </button>
            <button class="splide__arrow splide__arrow--next" data-slider-next>
                <svg class="i-arrow-right">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </button>
        </div>
    </div>
    <div class="container main-bestsellers__btn">
        <a class="btn btn--outline" href="<?=$arResult['LIST_PAGE_URL']?>">
        <span class="btn__text">
            <?= Loc::getMessage('BESTSELLER_PRODUCTS_SHOW_ALL') ?>
        </span>
        </a>
    </div>
</div>
