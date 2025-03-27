<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
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

if ($arResult ['PROPERTIES']['EXPERT']['VALUE']) {
    $expert = CIBlockElement::GetList(
        ['SORT' => 'ASC'],
        [
            'IBLOCK_ID' => $arResult ['PROPERTIES']['EXPERT']['LINK_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            '=ID' => $arResult ['PROPERTIES']['EXPERT']['VALUE']
        ],
        false,
        false,
        [
            'ID',
            'NAME',
            'PREVIEW_PICTURE',
            'PREVIEW_TEXT',
            'DETAIL_PAGE_URL'
        ]
    );
    $expertData = [];
    while ($block = $expert->GetNextElement()) {
        $expertData = $block->GetFields();
    }
    $arResult['PROPERTIES']['EXPERT_DATA'] = $expertData;
}
if ($arResult ['PROPERTIES']['PRODUCT_IN_CONTENT']['VALUE']) {
    $product = CIBlockElement::GetList(
        ['SORT' => 'ASC'],
        [
            'IBLOCK_ID' => $arResult ['PROPERTIES']['PRODUCT_IN_CONTENT']['LINK_IBLOCK_ID'],
            'ACTIVE' => 'Y',
            '=ID' => $arResult ['PROPERTIES']['PRODUCT_IN_CONTENT']['VALUE']
        ],
        false,
        false,
        [
            'ID',
            'NAME',
            'PREVIEW_PICTURE',
            'PREVIEW_TEXT',
            'DETAIL_PAGE_URL',
            'PROPERTY_BLACK_TITLE',
            'PROPERTY_GREY_TITLE'
        ]
    );
    $productData = [];
    while ($block = $product->GetNextElement()) {
        $productData = $block->GetFields();
    }
    $arResult['PROPERTIES']['PRODUCT_IN_CONTENT_DATA'] = $productData;
}
