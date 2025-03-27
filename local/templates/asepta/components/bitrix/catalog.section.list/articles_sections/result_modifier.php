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

if (!count($arResult['SECTIONS'])) {
    return false;
}

$arResult['URLS'][] = [
    'NAME' => Loc::getMessage('SECTIONS_SECTION_ALL'),
    'URL' => $arParams['LINK_TO_ALL'],
    'ACTIVE' => !$arParams['CURRENT_SECTION_CODE'] ? 'Y' : 'N',
];

foreach ($arResult['SECTIONS'] as $arSection) {
    if (!$arSection['ELEMENT_CNT']) {
        continue;
    }
    $arResult['URLS'][] = [
        'NAME' => $arSection['NAME'],
        'URL' => $arSection['SECTION_PAGE_URL'],
        'ACTIVE' => $arSection['CODE'] == $arParams['CURRENT_SECTION_CODE'] ? 'Y' : 'N',
    ];
}
