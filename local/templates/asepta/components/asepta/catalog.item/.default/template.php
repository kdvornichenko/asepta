<?php

use Olorchee\Template;
use Its\Library\Image\Resize;

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

$resize = new Resize((int)$arResult['~PREVIEW_PICTURE'], [800, 800], BX_RESIZE_IMAGE_PROPORTIONAL);
?>
<article class="catalog-body__product">
    <a class="product-card" href="<?= $arResult['DETAIL_PAGE_URL'] ?>">
        <?php
        if ($arResult['PROPERTIES']['STICKER']['VALUE']) {
            ?>
            <div class="product-card__tags">
                <span><?= $arResult['PROPERTIES']['STICKER']['VALUE'] ?></span>
            </div>
            <?php
        }
        ?>
        <div class="product-card__image">
            <?= $resize->getPictureTag([
                'alt' => htmlspecialchars($arResult['NAME']),
                'lazy' => true,
                'img_class' => 'lazy lazyload'
                ]) ?>
        </div>
        <div class="product-card__info">
            <p><?= $arResult['PROPERTIES']['GREY_TITLE']['VALUE'] ?></p>
            <p><?= $arResult['PROPERTIES']['BLACK_TITLE']['VALUE'] ?></p>
        </div>
        <button class="btn btn--icon btn--icon-big">
            <svg class="i-arrow-up-right"><use xlink:href="#arrow-up-right"></use></svg>
        </button>
    </a>
</article>
