<?php

use Its\Library\Iblock\Iblock;

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

$dbResSect = CIBlockSection::GetList(
    array("SORT" => "ASC"),
    array("IBLOCK_ID" => Iblock::getInstance()->getIblockIdByCode('partners'))
);
while ($sectRes = $dbResSect->GetNext()) {
    $arSections[] = $sectRes;
}

$arPartners = [];
foreach ($arResult['ITEMS'] as $link) {
    $resPartners = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('partners'),
            'ID' => $link['PROPERTIES']['SERVICE']['VALUE']
        ],
        false,
        false,
        ['ID', 'NAME', 'IBLOCK_SECTION_ID', 'PROPERTY_LOGO_SVG']
    );
    while ($arPartner = $resPartners->GetNext()) {
        $arPartner['LINK'] = $link["PROPERTIES"]["LINK"]["VALUE"];
        $arPartners [] = $arPartner;
    }
}

foreach ($arSections as $arSection) {
    foreach ($arPartners as $key => $arItem) {
        if ($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']) {
            $arSection['ELEMENTS'][] =  $arItem;
        }
    }
    if (!empty($arSection['ELEMENTS'])) {
        $arElementGroups[] = $arSection;
    }
}
$arResult["ITEMS"] = $arElementGroups;
