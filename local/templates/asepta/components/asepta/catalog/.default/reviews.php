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

$this->setFrameMode(true);
$componentElementParams = [
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'] ?? [],
    'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
    'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
    'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
    'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
    'BASKET_URL' => $arParams['BASKET_URL'],
    'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
    'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
    'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
    'CHECK_SECTION_ID_VARIABLE' => $arParams['DETAIL_CHECK_SECTION_ID_VARIABLE'] ?? '',
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
    'CACHE_TIME' => $arParams['CACHE_TIME'],
    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    'SET_TITLE' => $arParams['SET_TITLE'],
    'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
    'MESSAGE_404' => $arParams['~MESSAGE_404'],
    'SET_STATUS_404' => $arParams['SET_STATUS_404'],
    'SHOW_404' => $arParams['SHOW_404'],
    'FILE_404' => $arParams['FILE_404'],
    'PRICE_CODE' => $arParams['~PRICE_CODE'],
    'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
    'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
    'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
    'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'] ?? [],
    'ADD_PICT_PROP' => $arParams['DETAIL_ADD_PICT_PROP'] ?? [],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'] ?? '',
    'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'] ?? [],
    'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
    'OFFERS_PROPERTY_CODE' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'] ?? [],
    'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
    'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
    'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
    'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
    'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
    'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
    'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
    'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
    'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
    'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
    'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
    'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
    'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
    'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
    'STRICT_SECTION_CHECK' => $arParams['DETAIL_STRICT_SECTION_CHECK'] ?? '',
    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'] ?? [],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'] ?? '',
    'ADD_ELEMENT_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'] ?? '',
];
$elementId = $APPLICATION->IncludeComponent(
    'bitrix:catalog.element',
    'empty',
    $componentElementParams,
    $component
);
?>
<div class="reviews-body container">
    <?php
    $APPLICATION->IncludeComponent(
        'bitrix:breadcrumb',
        '',
        [
            'PATH' => '',
            'SITE_ID' => SITE_ID,
            'START_FROM' => 0,
        ],
        false,
        ['HIDE_ICONS' => 'Y']
    );
    ?>
    <h1><?= $APPLICATION->ShowTitle(false) ?></h1>
<?php
$GLOBALS['ELEMENT_REVIEWS_FILTER'] = [
    'PROPERTY_PRODUCTS' =>  $elementId,
];
$APPLICATION->IncludeComponent(
    'bitrix:news.list',
    'reviews_list',
    [
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('reviews'),
        'FILTER_NAME' => 'ELEMENT_REVIEWS_FILTER',
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_FILTER' => $arParams['CACHE_FILTER'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'],
        'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
        'SORT_BY1' => 'SORT',
        'PROPERTY_CODE' => ['FAKE'],
        'SORT_ORDER1' => 'ASC',
        'SORT_BY2' => 'ID',
        'SORT_ORDER2' => 'DESC',
        'DISPLAY_TOP_PAGER' => 'N',
        'DISPLAY_BOTTOM_PAGER' => 'N',
        'SET_TITLE' => 'Y',
        'ADD_SECTIONS_CHAIN' => 'N',
        'SET_LAST_MODIFIED' => 'N',
        'INCLUDE_SUBSECTIONS' => 'Y',
        'SHOW_ALL_WO_SECTION' => 'Y',
        'PAGE_ELEMENT_COUNT' => 15,
        'PRODUCT_DISPLAY_MODE' => 'Y',
        'SET_STATUS_404' => 'Y',
        'MESSAGE_404' => '',
        'SHOW_404' => 'Y',
        'FILE_404' => '',
    ],
    true
);
