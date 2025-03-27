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
    if ($arItem ['PROPERTIES']['EXPERT']['VALUE']) {
        $expert = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            [
                'IBLOCK_ID' => $arItem ['PROPERTIES']['EXPERT']['LINK_IBLOCK_ID'],
                'ACTIVE' => 'Y',
                '=ID' => $arItem ['PROPERTIES']['EXPERT']['VALUE']
            ],
            false,
            false,
            ['ID', 'NAME', 'PREVIEW_PICTURE']
        );
        $expertData = [];
        while ($block = $expert->GetNextElement()) {
            $expertData = $block->GetFields();
        }
        $arResult['ITEMS'][$key]['PROPERTIES']['EXPERT_DATA'] = $expertData;
        unset($expertData);
    }
}
