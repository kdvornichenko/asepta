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
<section class="modal modal--buy-product modal--right" data-modal="buy-product" data-lenis-prevent>
    <button class="modal__overlay" type="button" data-modal-close="buy-product"></button>
    <div class="modal__container">
        <div class="modal__content">
            <div class="modal-buy-product">
                <button class="modal-buy-product__close" type="button" data-modal-close="buy-product">
                    <svg class="i-cross">
                        <use xlink:href="#cross"></use>
                    </svg>
                </button>
                <div class="modal-buy-product__header">
                    <?=Loc::getMessage('WHERE_TO_BUY_LIST_TITLE') ?>
                </div>
                <div class="modal-buy-product__blocks">

                    <?php
                    foreach ($arResult['ITEMS'] as $key => $arSection) {
                        ?>
                    <div class="modal-buy-product__block">
                        <div class="modal-buy-product__block-header"><?= $arSection["NAME"] ?></div>
                        <div class="modal-buy-product__block-content">
                                <?php
                                foreach ($arSection['ELEMENTS'] as $arItem) {
                                    $resize = new Resize(
                                        (int)$arItem["PROPERTY_LOGO_SVG_VALUE"],
                                        [249, 97],
                                        BX_RESIZE_IMAGE_PROPORTIONAL
                                    );
                                    ?>
                                    <a class="modal-buy-product__item" href="<?= $arItem["LINK"] ?>" target="_blank">
                                        <div class="modal-buy-product__img-holder">
                                            <?php
                                            echo $resize->getPictureTag(
                                                [
                                                    'alt' => htmlspecialchars($arItem['NAME']),
                                                ]
                                            );?>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                <div class="modal-buy-product__btn">
                    <a class="btn btn--outline" href="/address/">
                        <span class="btn__text">
                            <?=Loc::getMessage('WHERE_TO_BUY_LIST_ALL') ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
