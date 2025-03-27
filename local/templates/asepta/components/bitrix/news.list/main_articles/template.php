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
$editParams = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
?>
<div class="main-experts" data-scroll-to-block>
    <h2><?= Loc::getMessage('MAIN_ARTICLES_TITLE') ?></h2>
    <div class="swiper main-experts__body container" data-slider="mobile-full">
        <div class="swiper-wrapper main-experts__body-wrapper">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $editParams);
                $resize = new Resize(intval($arItem['~PREVIEW_PICTURE']), [800, 972]);
                $resizeExpert = new Resize(intval($arItem ['PROPERTIES']['EXPERT_DATA']['PREVIEW_PICTURE']), [40, 40]);
                ?>
            <div class="swiper-slide main-experts__item"
                 data-parallax="fadeIn"
                 id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                <a class="expert-card" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <div class="expert-card__background">
                       <?php
                        echo $resize->getPictureTag(
                            [
                                'alt' => htmlspecialchars($arItem['NAME']),
                            ]
                        );?>
                    </div>
                    <p><?=$arItem['NAME']?></p>
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
    <a class="btn btn--outline main-experts__btn"
       href="<?= $arResult["LIST_PAGE_URL"] ?>">
        <span class="btn__text">
            <?= Loc::getMessage('MAIN_ARTICLES_SHOW_MORE') ?>
        </span>
    </a>
</div>
