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

$resElements = CIBlockElement::GetList(
    [],
    ['IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('banners'), 'ACTIVE' => 'Y'],
    false,
    ["nPageSize" => 2, "iNumPage" => (int)$_REQUEST['PAGEN_1']],
    ['ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_LINK', 'PROPERTY_BUTTON_TEXT']
);
while ($arElement = $resElements->GetNext()) {
    $arElement['TYPE'] = 'banner';
    $arBanners [] = $arElement;
}

$bannersIndex = 0;
$itemsIndex = 0;
$right = true;
$lastIndex = 2;
$arItems = [];
while ($itemsIndex < count($arResult['ITEMS'])) {
    if ($bannersIndex < count($arBanners)) {
        if (($right && $itemsIndex == $lastIndex + 8) || $itemsIndex == $lastIndex) {
            $arItems[] = $arBanners[$bannersIndex];
            $bannersIndex++;
            $right = false;
            $lastIndex = $itemsIndex;
        } else {
            $arItems[] = $arResult['ITEMS'][$itemsIndex];
            $itemsIndex++;
        }
        if (!$right && $itemsIndex == $lastIndex + 4) {
            $arItems[] = $arBanners[$bannersIndex];
            $bannersIndex++;
            $right = true;
            $lastIndex = $itemsIndex;
        } else {
            $arItems[] = $arResult['ITEMS'][$itemsIndex];
            $itemsIndex++;
        }
    } else {
        $arItems[] = $arResult['ITEMS'][$itemsIndex];
        $itemsIndex++;
    }
}
$arResult['ITEMS'] = $arItems;
