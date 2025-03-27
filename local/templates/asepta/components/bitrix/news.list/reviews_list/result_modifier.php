<?php

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

foreach ($arResult['ITEMS'] as $key => $arItem) {
    if ($arItem ['PROPERTIES']['PARTNER']['VALUE']) {
        $partner = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            [
                'IBLOCK_ID' => $arItem ['PROPERTIES']['PARTNER']['LINK_IBLOCK_ID'],
                'ACTIVE' => 'Y',
                '=ID' => $arItem ['PROPERTIES']['PARTNER']['VALUE']
            ],
            false,
            false,
            ['ID', 'NAME', 'PROPERTY_LOGO_CIRCLE']
        );
        $partnerData = [];
        while ($block = $partner->GetNextElement()) {
            $partnerData = $block->GetFields();
        }
        $arResult['ITEMS'][$key]['PROPERTIES']['PARTNER_DATA'] = $partnerData;
        unset($partnerData);
    }
}
