<?php

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
/** @var CIBlockResult $navResult */

$this->setFrameMode(true);

if (empty($arResult['ITEMS'])) {
    return;
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = ['CONFIRM' => Loc::getMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM')];
?>
<div class="product-offers">
    <div class="container">
        <h2> <?= $arParams['SECTION_TITLE'] ?: Loc::getMessage('SIMILAR_PRODUCTS') ?></h2>
    </div>
    <div class="swiper product-offers__list container" data-slider="loop-line" data-init-breakpoint="1024">
        <div class="swiper-wrapper">
            <?php
            foreach ($arResult['ITEMS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $elementEdit);
                ?>
                <div class="swiper-slide product-offers__item">
                    <?php
                    $APPLICATION->IncludeComponent(
                        'asepta:catalog.item',
                        '',
                        [
                            'CURRENT_FILTER' => $arParams['CURRENT_FILTER'],
                            'ITEM' => $arItem,
                            'AREA_ID' => $this->GetEditAreaId($arItem['ID']),
                            'USE_SMART_FILTER' => $arParams['USE_SMART_FILTER']
                        ],
                        $component,
                        ['HIDE_ICONS' => 'Y']
                    );
                    ?>
                </div>
                    <?php
            }
            ?>
        </div>
    </div>
</div>
