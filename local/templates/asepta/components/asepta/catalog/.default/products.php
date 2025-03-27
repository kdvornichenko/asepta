<?php

use Bitrix\Catalog\GroupTable;
use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
use Its\Library\Asset\AssetManager;
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
Loader::includeModule('catalog');

AssetManager::getInstance()->addJs(SITE_TEMPLATE_PATH . '/section.js');

$request = Context::getCurrent()->getRequest();

$filterParams = [
    'PREFILTER_NAME' => "PRE_{$arParams['FILTER_NAME']}",
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
    'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
    'FILTER_NAME' => $arParams['FILTER_NAME'],
    'PRICE_CODE' => $arParams['~PRICE_CODE'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
    'CACHE_TIME' => $arParams['CACHE_TIME'],
    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    'SAVE_IN_SESSION' => 'N',
    'XML_EXPORT' => 'N',
    'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
    'SEF_MODE' => $arParams['SEF_MODE'],
    'SEF_RULE' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['smart_filter'],
    'SMART_FILTER_PATH' => $arResult['VARIABLES']['SMART_FILTER_PATH'],
    'PAGER_PARAMS_NAME' => $arParams['PAGER_PARAMS_NAME'],
    'INSTANT_RELOAD' => $arParams['INSTANT_RELOAD'],
    'DISPLAY_ELEMENT_COUNT' => 'Y',
    'SHOW_ALL_WO_SECTION' => 'Y',
    'STATIC_VALUES' => $arResult['STATIC_FILTER_VALUES'],
];

$sectionParams = [
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
    'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
    'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
    'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
    'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
    'CACHE_TIME' => $arParams['CACHE_TIME'],
    'CACHE_FILTER' => $arParams['CACHE_FILTER'],
    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
    'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
    'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
    'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
    'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
    'META_KEYWORDS' => $arParams['LIST_META_KEYWORDS'],
    'META_DESCRIPTION' => $arParams['LIST_META_DESCRIPTION'],
    'BROWSER_TITLE' => $arParams['LIST_BROWSER_TITLE'],
    'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
    'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
    'BASKET_URL' => $arParams['BASKET_URL'],
    'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
    'FILTER_NAME' => $arParams['FILTER_NAME'],
    'SET_TITLE' => $arParams['SET_TITLE'],
    'MESSAGE_404' => $arParams['~MESSAGE_404'],
    'SET_STATUS_404' => $arParams['SET_STATUS_404'],
    'SHOW_404' => $arParams['SHOW_404'],
    'FILE_404' => $arParams['FILE_404'],
    'PAGE_ELEMENT_COUNT' => $arParams['PAGE_ELEMENT_COUNT'],
    'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'] ?? [],
    'PRICE_CODE' => $arParams['~PRICE_CODE'],
    'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
    'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
    'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'] ?? '',
    'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'] ?? '',
    'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'] ?? [],
    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
    'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
    'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
    'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
    'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
    'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
    'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
    'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
    'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'] ?? [],
    'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
    'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'] ?? [],
    'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
    'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
    'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
    'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
    'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'] ?? 0,
    'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
    'DISPLAY_COMPARE' => 'N',
    'DISABLE_INIT_JS_IN_COMPONENT' => $arParams['DISABLE_INIT_JS_IN_COMPONENT'] ?? '',
    'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'] ?? [],
    'PRODUCT_DISPLAY_MODE' => 'Y',
    'SHOW_ALL_WO_SECTION' => 'Y',
];
if ($arResult['DISABLE_META'] === 'Y') {
    $sectionParams['SET_TITLE'] = 'N';
    $sectionParams['ADD_SECTIONS_CHAIN'] = 'N';
    $sectionParams['SET_LAST_MODIFIED'] = 'N';
}

if ($arResult['FILTER_SEF_URL_TEMPLATE']) {
    $filterParams['SEF_RULE'] = $arResult['FOLDER'] . $arResult['URL_TEMPLATES'][$arResult['FILTER_SEF_URL_TEMPLATE']];
    $filterParams['SEF_RULE'] = preg_replace_callback(
        '/#[A-Z0-9_]+#/',
        function (array $matches) use ($arResult): string {
            $key = preg_replace('/#/', '', $matches[0]);
            if ($key == 'SMART_FILTER_PATH' || !isset($arResult['VARIABLES'][$key])) {
                return $matches[0];
            }
            return $arResult['VARIABLES'][$key];
        },
        $filterParams['SEF_RULE']
    );
}
if ($arResult['PREFILTER']) {
    $GLOBALS[$filterParams['PREFILTER_NAME']] = $arResult['PREFILTER'];
}

$this->SetViewTarget('MODAL_CATALOG_FILTER');
?>
<section class="modal modal--filters modal--right" data-modal="filters">
    <button class="modal__overlay" type="button" data-modal-close="filters">
        <button class="modal__mobile-close"></button>
    </button>
    <div class="modal__container">
        <?php
        $APPLICATION->IncludeComponent(
            'bitrix:catalog.smart.filter',
            '',
            $filterParams,
            $component,
            ['HIDE_ICONS' => 'Y']
        );
        ?>
    </div>
</section>
<?php
$this->EndViewTarget();
?>
<div class="catalog-body container" >
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
    <div class="catalog-body__filters">
        <?php
        $APPLICATION->IncludeComponent(
            'bitrix:catalog.section.list',
            '.default',
            [
                'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                'CACHE_TIME' => $arParams['CACHE_TIME'],
                'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                'COUNT_ELEMENTS' => $arParams['SECTION_COUNT_ELEMENTS'],
                'TOP_DEPTH' => $arParams['SECTION_TOP_DEPTH'],
                'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
                'CURRENT_SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                'SECTION_PAGE' => $arResult['SECTION_PAGE'],
                'ADD_SECTIONS_CHAIN' => 'N',
                'ADDITIONAL_COUNT_ELEMENTS_FILTER' => 'CATALOG_COUNT_FILTER',
                'URL' => $APPLICATION->GetCurPage(false)
            ],
            $component,
            ['HIDE_ICONS' => 'Y']
        );
        ?>
        <button class="btn btn--outline" data-modal-open="filters">
            <svg class="i-tooth-transparent"><use xlink:href="#tooth-transparent"></use></svg>
            <span class="btn__text">
                <?= Loc::getMessage('SECTION_FILTER_BTN_TITLE') ?>
            </span>
        </button>
    </div>
    <div id="jsCatalogSectionWrap">
        <?php $APPLICATION->IncludeComponent(
            'bitrix:catalog.section',
            '.default',
            $sectionParams,
            $component,
            ['HIDE_ICONS' => 'Y']
        )?>

    <div class="catalog-body__btn jsPageNavigationWrap">
        <?php $APPLICATION->ShowViewContent('catalog_pagination'); ?>
    </div>
    </div>
    <button class="btn btn--outline catalog-body__fixed-btn"
            data-modal-open="filters"
            data-active-inner=".catalog-body__list"
            data-active-inner-rate="400">
        <svg class="i-tooth-transparent"><use xlink:href="#tooth-transparent"></use></svg>
        <span class="btn__text"><?= Loc::getMessage('SECTION_FILTER_BTN_TITLE') ?></span>
    </button>
</div>

<?php
$APPLICATION->IncludeComponent(
    'bitrix:news.list',
    'partners_slider',
    [
        'IBLOCK_TYPE' => 'service',
        'IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('partners'),
        'NEWS_COUNT' => 6,
        'SORT_BY1' => 'SORT',
        'SORT_ORDER1' => 'ASC',
        'SORT_BY2' => 'ACTIVE_FROM',
        'SORT_ORDER2' => 'DESC',
        'FILTER_NAME' => '',
        'FIELD_CODE' => [],
        'PROPERTY_CODE' => ['LOGO_SVG', 'LINK'],
        'CHECK_DATES' => 'Y',
        'DETAIL_URL' => '',
        'AJAX_MODE' => 'N',
        "CACHE_TYPE" => 'A',
        "CACHE_TIME" => 360000,
        "CACHE_GROUPS" => '',
        'CACHE_FILTER' => 'N',
        'PREVIEW_TRUNCATE_LEN' => '',
        'ACTIVE_DATE_FORMAT' => '',
        'SET_TITLE' => 'N',
        'SET_BROWSER_TITLE' => 'N',
        'SET_META_KEYWORDS' => 'N',
        'SET_META_DESCRIPTION' => 'N',
        'SET_LAST_MODIFIED' => 'Y',
        'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
        'ADD_SECTIONS_CHAIN' => 'N',
        'INCLUDE_SUBSECTIONS' => 'Y',
        'STRICT_SECTION_CHECK' => 'N',
        'PAGER_TEMPLATE' => '',
        'DISPLAY_TOP_PAGER' => 'N',
        'DISPLAY_BOTTOM_PAGER' => 'N',
        'PAGER_DESC_NUMBERING' => 'N',
        'SET_STATUS_404' => 'N',
    ],
    false,
    ['HIDE_ICONS' => 'Y']
);
?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.CatalogSection = new SectionPage(
            {
                wrapId: 'jsCatalogSectionWrap',
                orderSelectClass: 'jsCatalogSectionOrder',
                pageNavigationClass: 'jsPageNavigationWrap',
                showMoreClass: 'jsPageNavigationShowMoreButton',
                elementListClass: 'jsCatalogSectionElementListWrap',
            }
        );
    });
</script>
