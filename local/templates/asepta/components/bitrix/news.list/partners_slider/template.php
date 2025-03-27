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
}?>
<div class="catalog-brends">
    <div class="catalog-brends__title container">
        <h2> <?=Loc::getMessage('BRANDS_LIST_TITLE') ?></h2>
    </div>
    <div class="swiper catalog-brends__slider container" data-slider="scroll">
        <div class="swiper-wrapper catalog-brends__slider-wrapper">

            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                $resize = new Resize(
                    (int)$arItem["PROPERTIES"]["LOGO_SVG"]["VALUE"],
                    [450, 200],
                    BX_RESIZE_IMAGE_PROPORTIONAL
                );
                ?>
                <div class="swiper-slide catalog-brends__slide" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <a target="_blank" href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>">
                        <?php
                            echo $resize->getPictureTag(
                                [
                                    'alt' => htmlspecialchars($arItem['NAME']),
                                ]
                            );?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="catalog-brends__btn">
        <a class="btn btn--outline" href="<?= $arResult["LIST_PAGE_URL"] ?>">
            <span class="btn__text">
                <?=Loc::getMessage('BRANDS_LIST_ALL') ?>
            </span>
        </a>
    </div>
</div>
