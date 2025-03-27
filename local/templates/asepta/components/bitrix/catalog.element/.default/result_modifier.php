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

foreach ($arResult['PROPERTIES']['WHERE_TO_BUY']['VALUE'] as $propertyLinkId) {
    $resLinks = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => $arResult['PROPERTIES']['WHERE_TO_BUY']['LINK_IBLOCK_ID'], 'ID' => $propertyLinkId],
        false,
        false,
        ['ID', 'NAME', 'PROPERTY_SERVICE', 'PROPERTY_LINK']
    );
    while ($arLink = $resLinks->GetNext()) {
        $resPartnerLogo = CIBlockElement::GetProperty(
            Iblock::getInstance()->getIblockIdByCode('partners'),
            $arLink['PROPERTY_SERVICE_VALUE'],
            "sort",
            "asc",
            ["CODE" => "LOGO_CIRCLE"]
        );
        if ($logo = $resPartnerLogo->GetNext()) {
            $arLink['PROPERTY_LOGO_VALUE'] = $logo['VALUE'];
        }
        $arResult['PROPERTIES']['WHERE_TO_BUY']['VALUE_CONTENT'][] = $arLink;
    }
}

foreach ($arResult['PROPERTIES']['TABS']['~VALUE'] as $key => $tab) {
    $arResult['PROPERTIES']['TABS']['~VALUE'][$key]['TITLE'] = $arResult['PROPERTIES']['TABS']['DESCRIPTION'][$key];
}
