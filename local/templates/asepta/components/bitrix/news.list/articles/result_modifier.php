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

foreach ($arResult['ITEMS'] as $key => $arItem) {
    $res = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);
    if ($ar_res = $res->GetNext()) {
        $arResult['ITEMS'][$key]['SECTION'] = $ar_res['NAME'];
    }
}
