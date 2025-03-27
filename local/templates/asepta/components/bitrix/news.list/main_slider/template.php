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
<div class="main-hero container">
    <div class="swiper main-hero__slider" data-slider="full-page">
        <div class="swiper-wrapper">
            <?php
            foreach ($arResult['ITEMS'] as $key => $itemData) {
                $this->AddEditAction(
                    $itemData['ID'],
                    $itemData['EDIT_LINK'],
                    CIBlock::GetArrayByID($itemData["IBLOCK_ID"], "ELEMENT_EDIT")
                );
                $this->AddDeleteAction(
                    $itemData['ID'],
                    $itemData['DELETE_LINK'],
                    CIBlock::GetArrayByID($itemData["IBLOCK_ID"], "ELEMENT_DELETE"),
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
                );
                $resize = new Resize(intval($itemData['~PREVIEW_PICTURE']), [2400, 1275], BX_RESIZE_IMAGE_EXACT, [Resize::SHARPEN_OFF]);
                $resizeMobile = new Resize(intval($itemData['PROPERTIES']['MOBILE_PICTURE']['VALUE']), [800, 800]);
                 ?>
                <div class="swiper-slide main-hero__slide" id="<?= $this->GetEditAreaId($itemData['ID']); ?>">
                    <div class="main-hero__top">
                        <p><?=$itemData['PREVIEW_TEXT']?></p>
                    </div>
                    <picture>
                        <source type="image/webp" srcset="<?= $resize->getResult()['types']['webp']?>" media="(min-width: 1024px)">
                        <source type="image/jpeg" srcset="<?= $resize->getResult()['src']?>" media="(min-width: 768px) and (max-width: 1023px)">
                        <source type="image/webp" srcset="<?= $resize->getResult()['types']['webp']?>" media="(min-width: 768px) and (max-width: 1023px)">
                        <source type="image/jpeg" srcset="<?= $resizeMobile->getResult()['src']?>" media="(max-width: 767px)">
                        <source type="image/webp" srcset="<?= $resizeMobile->getResult()['types']['webp']?>" media="(max-width: 767px)">
                        <source type="image/jpeg" srcset="<?= $resize->getResult()['src']?>" media="(min-width: 1024px)">
                        <img class="main-hero__background" src="<?= $resize->getResult()['src']?>" alt="">
                    </picture>
                    <div class="main-hero__bottom">
                        <p>
                            <?=$itemData['PROPERTIES']['TITLE']['~VALUE']?>
                        </p>
                        <?php
                        if (!empty($itemData['PROPERTIES']['LINK']['VALUE']) && !empty($itemData['PROPERTIES']['BUTTON_TEXT']['VALUE'])) { ?>
                            <a class="btn btn--white btn--small" href="<?= $itemData['PROPERTIES']['LINK']['VALUE'] ?>">
                            <span class="btn__text"><?= $itemData['PROPERTIES']['BUTTON_TEXT']['VALUE'] ?></span>
                            </a>
                            <?php
                        } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="main-hero__progress" data-slider-progress>
            <div class="main-hero__progress-line"></div>
        </div>
        <div class="main-hero__pagination">
            <div class="main-hero__pagination-list" data-slider-pagination></div>
        </div>
    </div>
</div>
