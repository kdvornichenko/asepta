<?php

use Olorchee\Template;
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

$resize = new Resize((int)$arResult['~PREVIEW_PICTURE'], [1120, 660], BX_RESIZE_IMAGE_PROPORTIONAL);
?>
<article class="catalog-body__product catalog-body__product--article">
    <a href="<?= $arResult['PROPERTY_LINK_VALUE'] ?>">
        <p><?= $arResult['NAME'] ?>
        </p>
        <button class="btn btn--white btn--small">
            <span class="btn__text">
                <?= $arResult['PROPERTY_BUTTON_TEXT_VALUE'] ?>
            </span>
        </button>
        <?= $resize->getPictureTag([
            'alt' => htmlspecialchars($arResult['NAME']),
            'lazy' => true,
            'img_class' => 'lazy lazyload'
        ]) ?>
    </a>
</article>
