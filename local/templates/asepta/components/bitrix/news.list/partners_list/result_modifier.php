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
    array("IBLOCK_ID" => $arParams['IBLOCK_ID'])
);
while ($sectRes = $dbResSect->GetNext()) {
    $arSections[] = $sectRes;
}
foreach ($arSections as $arSection) {
    foreach ($arResult["ITEMS"] as $key => $arItem) {
        if ($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']) {
            $arSection['ELEMENTS'][] =  $arItem;
        }
    }
    $arElementGroups[] = $arSection;
}
$arResult["ITEMS"] = $arElementGroups;
