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

$this->setFrameMode(false);

$arPhotos = [];

$resize = new Resize(
    (int)$arResult['~DETAIL_PICTURE'],
    [1500, 1500],
    BX_RESIZE_IMAGE_PROPORTIONAL
);

$resizeThumbnail = new Resize(
    (int)$arResult['~DETAIL_PICTURE'],
    [200, 220],
    BX_RESIZE_IMAGE_PROPORTIONAL
);

$arPhotos[] = [
    'full' => $resize->getPictureTag([
        'no_photo' => '/assets/img/svg/no-photo.svg',
        'lazy' => true,
        'alt' => htmlspecialchars($arResult['DETAIL_PICTURE']['ALT']),
        'img_class' => 'lazy lazyload shop-product-slider__img',
    ]),
    'thumbnail' => $resizeThumbnail->getPictureTag([
        'no_photo' => '/assets/img/svg/no-photo.svg',
        'lazy' => true,
        'alt' => htmlspecialchars($arResult['DETAIL_PICTURE']['ALT']),
        'img_class' => 'lazy lazyload',
    ]),
];

$additionalPhotos = $arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'];
if (!empty($additionalPhotos)) {
    foreach ($additionalPhotos as $arPhotoItem) {
        $resize = new Resize(
            (int)$arPhotoItem,
            [1500, 1500],
            BX_RESIZE_IMAGE_PROPORTIONAL
        );

        $resizeThumbnail = new Resize(
            (int)$arPhotoItem,
            [200, 220],
            BX_RESIZE_IMAGE_PROPORTIONAL
        );

        $arPhotos[] = [
            'full' => $resize->getPictureTag([
                'no_photo' => '/assets/img/svg/no-photo.svg',
                'lazy' => true,
                'alt' => htmlspecialchars($arResult['DETAIL_PICTURE']['ALT']),
                'img_class' => 'lazy lazyload shop-product-slider__img',
            ]),
            'thumbnail' => $resizeThumbnail->getPictureTag([
                'no_photo' => '/assets/img/svg/no-photo.svg',
                'lazy' => true,
                'alt' => htmlspecialchars($arResult['DETAIL_PICTURE']['ALT']),
                'img_class' => 'lazy lazyload',
            ]),
        ];
    }
}
?>
<div class="product-hero container">
    <div class="product-hero__gallery">
        <div class="product-gallery" data-slider-wrapper>
            <div class="swiper product-gallery__main" data-slider-body>
                <div class="swiper-wrapper">
                    <?php
                    foreach ($arPhotos as $arPhoto) {
                        ?>
                        <div class="swiper-slide product-gallery__main-slide">
                            <?= $arPhoto['full'] ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="swiper product-gallery__thumbs" data-slider-thumbs>
                <div class="swiper-wrapper product-gallery__thumbs-wrapper">
                    <?php
                    foreach ($arPhotos as $arPhoto) {
                        ?>
                        <div class="swiper-slide product-gallery__thumbs-slide">
                            <?= $arPhoto['thumbnail'] ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="product-hero__info">
        <div class="product-hero__info-main">
            <p class="product-hero__info-article"><?= $arResult['PROPERTIES']['SERIES']['VALUE'] ?></p>
            <h1><?= $arResult['NAME'] ?></h1>
            <p class="product-hero__info-description">
                <?= $arResult['PREVIEW_TEXT'] ?>
            </p>
            <ul class="product-hero__advantages">
                <?php
                foreach ($arResult['PROPERTIES']['ADVANTAGES']['VALUE'] as $advantages) {
                    ?>
                    <li>
                        <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:main.include',
                            'catalog_detail_advantages',
                            [
                                'AREA_FILE_SHOW' => 'file',
                                'PATH' => SITE_TEMPLATE_PATH . '/include_area/' . SITE_ID . '/catalog_detail_advantages_icon.php',
                            ],
                            true
                        );
                        ?>
                        <p><?= $advantages ?></p>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="product-hero__info-btns">
                <a class="btn btn--fill"
                   data-modal-url="/local/ajax/modal-buy-product.php?id=<?=$arResult['ID']?>"
                   data-modal-open="buy-product">
                    <span class="btn__text">
                        <?= Loc::getMessage('WHERE_TO_BUY') ?>
                    </span>
                </a>
                <?php
                foreach ($arResult['PROPERTIES']['WHERE_TO_BUY']['VALUE_CONTENT'] as $link) {
                    $resizeLink = new Resize(
                        (int)$link['PROPERTY_LOGO_VALUE'],
                        [106, 106],
                        BX_RESIZE_IMAGE_PROPORTIONAL
                    );
                    ?>
                    <a href="<?= $link['PROPERTY_LINK_VALUE'] ?>" target="_blank">
                        <img src="<?= $resizeLink->getResult()['src']?>" alt="<?= $link['NAME'] ?>">
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="product-hero__acc-wrapper">
            <?php
            foreach ($arResult['PROPERTIES']['TABS']['~VALUE'] as $key => $tab) {
                ?>
                <div class="product-hero__acc" data-acc>
                    <div class="product-hero__acc-btn <?= $key == 0 ? ' is-active' : '' ?>"
                         data-acc-btn="info-product">
                        <p><?= $tab['TITLE'] ?></p>
                        <svg class="i-arrow-down-add">
                            <use xlink:href="#arrow-down-add"></use>
                        </svg>
                    </div>
                    <div class="product-hero__acc-content <?= $key == 0 ? ' is-open' : '' ?>"
                         data-acc-content="info-product">
                        <div class="product-hero__acc-content-inner" data-acc-content-inner>
                            <?= $tab['TEXT'] ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            if (!empty($arResult['PROPERTIES']['RESEARCH']['VALUE']) || !empty($arResult['PROPERTIES']['RESEARCH_FILE']['VALUE'])) {
                ?>
                <div class="product-hero__acc" data-acc>
                    <div class="product-hero__acc-btn"
                         data-acc-btn="info-product">
                        <p><?= Loc::getMessage('CATALOG_ELEMENT_RESEARCH_TITLE') ?></p>
                        <svg class="i-arrow-down-add">
                            <use xlink:href="#arrow-down-add"></use>
                        </svg>
                    </div>
                    <div class="product-hero__acc-content"
                         data-acc-content="info-product">
                        <div class="product-hero__acc-content-inner" data-acc-content-inner>
                            <?php
                            if (!empty($arResult['PROPERTIES']['RESEARCH']['VALUE'])) {
                                foreach ($arResult['PROPERTIES']['RESEARCH']['VALUE'] as $link) {
                                    ?>
                                    <a href="<?= $link ?>" target="_blank">
                                        <span><?= Loc::getMessage('CATALOG_ELEMENT_RESEARCH_LINK_OPEN') ?></span>
                                        <svg class="i-arrow-up-right">
                                            <use xlink:href="#arrow-up-right"></use>
                                        </svg>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if (!empty($arResult['PROPERTIES']['RESEARCH_FILE']['VALUE'])) {
                                foreach ($arResult['PROPERTIES']['RESEARCH_FILE']['VALUE'] as $key => $arFile) {
                                    $document = Cfile::GetFileArray($arFile);
                                    ?>
                                    <a href="<?=$document["SRC"]?>" target="_blank">
                                        <span>
                                            <?= $arResult['PROPERTIES']['RESEARCH_FILE']['DESCRIPTION'][$key] ?: Loc::getMessage('CATALOG_ELEMENT_RESEARCH_LINK_OPEN') ?>
                                        </span>
                                        <svg class="i-arrow-up-right">
                                            <use xlink:href="#arrow-up-right"></use>
                                        </svg>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
