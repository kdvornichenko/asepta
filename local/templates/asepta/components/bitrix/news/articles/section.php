<?php

use Its\Library\Asset\AssetManager;

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

$this->setFrameMode(false);
AssetManager::getInstance()->addJs(SITE_TEMPLATE_PATH . '/section.js');
?>
<div class="page" data-page="articles">
    <div class="page__inner">
        <div class="articles container">
            <div class="articles__top" id="jsBlogSectionWrap">
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
                <div class="articles__filters">
                    <?php
                    $APPLICATION->IncludeComponent(
                        'bitrix:catalog.section.list',
                        'articles_sections',
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
                            'LINK_TO_ALL' => $arResult['FOLDER'],
                            'ADD_SECTIONS_CHAIN' => 'N',
                            'SECTION_USER_FIELDS' => [],
                            'ADDITIONAL_COUNT_ELEMENTS_FILTER' => '',
                        ],
                        $component,
                        ['HIDE_ICONS' => 'Y']
                    );
                    ?>
                </div>
                <div class="articles__body">
                    <?php
                    $APPLICATION->IncludeComponent(
                        'bitrix:news.list',
                        'articles',
                        [
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'NEWS_COUNT' => $arParams['NEWS_COUNT'],
                            'SORT_BY1' => $arParams['SORT_BY1'],
                            'SORT_ORDER1' => $arParams['SORT_ORDER1'],
                            'SORT_BY2' => $arParams['SORT_BY2'],
                            'SORT_ORDER2' => $arParams['SORT_ORDER2'],
                            'FIELD_CODE' => $arParams['LIST_FIELD_CODE'],
                            'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
                            'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'],
                            'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
                            'IBLOCK_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['news'],
                            'SET_TITLE' => 'N',
                            'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
                            'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
                            'MESSAGE_404' => $arParams['MESSAGE_404'],
                            'SET_STATUS_404' => $arParams['SET_STATUS_404'],
                            'SHOW_404' => $arParams['SHOW_404'],
                            'FILE_404' => $arParams['FILE_404'],
                            'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                            'CACHE_TIME' => $arParams['CACHE_TIME'],
                            'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'DISPLAY_TOP_PAGER' => $arParams['DISPLAY_TOP_PAGER'],
                            'DISPLAY_BOTTOM_PAGER' => $arParams['DISPLAY_BOTTOM_PAGER'],
                            'PAGER_TITLE' => $arParams['PAGER_TITLE'],
                            'PAGER_TEMPLATE' => $arParams['PAGER_TEMPLATE'],
                            'PAGER_SHOW_ALWAYS' => $arParams['PAGER_SHOW_ALWAYS'],
                            'PAGER_DESC_NUMBERING' => $arParams['PAGER_DESC_NUMBERING'],
                            'PAGER_DESC_NUMBERING_CACHE_TIME' => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                            'PAGER_SHOW_ALL' => $arParams['PAGER_SHOW_ALL'],
                            'PAGER_BASE_LINK_ENABLE' => $arParams['PAGER_BASE_LINK_ENABLE'],
                            'PAGER_BASE_LINK' => $arParams['PAGER_BASE_LINK'],
                            'PAGER_PARAMS_NAME' => $arParams['PAGER_PARAMS_NAME'],
                            'PREVIEW_TRUNCATE_LEN' => $arParams['PREVIEW_TRUNCATE_LEN'],
                            'ACTIVE_DATE_FORMAT' => $arParams['LIST_ACTIVE_DATE_FORMAT'],
                            'USE_PERMISSIONS' => $arParams['USE_PERMISSIONS'],
                            'GROUP_PERMISSIONS' => $arParams['GROUP_PERMISSIONS'],
                            'CHECK_DATES' => $arParams['CHECK_DATES'],
                            'STRICT_SECTION_CHECK' => $arParams['STRICT_SECTION_CHECK'],
                            'PARENT_SECTION' => $arResult['VARIABLES']['SECTION_ID'],
                            'PARENT_SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                        ],
                        $component,
                        ['HIDE_ICONS' => 'Y']
                    );
                    ?>
                </div>
                <div class="articles__pagination jsPageNavigationWrap">
                    <?php $APPLICATION->ShowViewContent('articles_pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.CatalogSection = new SectionPage(
            {
                wrapId: 'jsBlogSectionWrap',
                pageNavigationClass: 'jsPageNavigationWrap',
                showMoreClass: 'jsPageNavigationShowMoreButton',
                elementListClass: 'jsArticlesSectionElementListWrap',
            }
        );
    });
</script>
