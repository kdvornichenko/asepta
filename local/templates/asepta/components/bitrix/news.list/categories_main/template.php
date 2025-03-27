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
<div class="main-catalog container" data-scroll-to-block data-offset="-350" data-main-catalog>
    <div class="main-catalog__inner">
        <h2> <?= Loc::getMessage('MAIN_CATALOG_TITLE') ?></h2>
        <div class="swiper main-catalog__list" data-slider="coverflow">
            <div class="swiper-wrapper">
                <?php
                foreach ($arResult['ITEMS'] as $key => $itemData) {
                    $resize = new Resize(
                        intval($itemData['~PREVIEW_PICTURE']),
                        [444, 705],
                        BX_RESIZE_IMAGE_EXACT,
                        [Resize::SHARPEN_OFF]
                    );
                    ?>
                <div class="swiper-slide main-catalog__card">
                    <a
                        class="catalog-card"
                        <?php
                        if ($itemData['PROPERTIES']['LINK']['VALUE']) {
                            ?>
                            href="<?= $itemData['PROPERTIES']['LINK']['VALUE'] ?>"
                            <?php
                        }
                        ?>>
                        <p><?=$itemData['PROPERTIES']['TITLE']['~VALUE']?></p>
                        <?php
                        echo $resize->getPictureTag();
                        ?>
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
            <div class="swiper-scrollbar" data-slider-scrollbar></div>
        </div>
        <div class="main-catalog__btn">
            <a class="btn btn--outline" href="/catalog/">
                <span class="btn__text">
                    <?= Loc::getMessage('MAIN_CATALOG_SHOW_MORE') ?>
                </span>
            </a>
        </div>
    </div>
</div>
