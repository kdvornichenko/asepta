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

$this->setFrameMode(false);
?>
<div class="page" data-page="article">
    <div class="page__inner">
          <div class="article container">
              <div class="article__top">
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
                  <?php $APPLICATION->ShowViewContent('articles_top_banner'); ?>
              </div>
                    <?php
                    $elementId = $APPLICATION->IncludeComponent(
                        'bitrix:news.detail',
                        'article',
                        [
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'FIELD_CODE' => $arParams['DETAIL_FIELD_CODE'],
                            'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
                            'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'],
                            'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
                            'META_KEYWORDS' => $arParams['META_KEYWORDS'],
                            'META_DESCRIPTION' => $arParams['META_DESCRIPTION'],
                            'BROWSER_TITLE' => $arParams['BROWSER_TITLE'],
                            'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
                            'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
                            'SET_TITLE' => $arParams['SET_TITLE'],
                            'MESSAGE_404' => $arParams['MESSAGE_404'],
                            'SET_STATUS_404' => $arParams['SET_STATUS_404'],
                            'SHOW_404' => $arParams['SHOW_404'],
                            'FILE_404' => $arParams['FILE_404'],
                            'INCLUDE_IBLOCK_INTO_CHAIN' => $arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
                            'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
                            'ACTIVE_DATE_FORMAT' => $arParams['DETAIL_ACTIVE_DATE_FORMAT'],
                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                            'CACHE_TIME' => $arParams['CACHE_TIME'],
                            'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                            'USE_PERMISSIONS' => $arParams['USE_PERMISSIONS'],
                            'GROUP_PERMISSIONS' => $arParams['GROUP_PERMISSIONS'],
                            'DISPLAY_TOP_PAGER' => $arParams['DETAIL_DISPLAY_TOP_PAGER'],
                            'DISPLAY_BOTTOM_PAGER' => $arParams['DETAIL_DISPLAY_BOTTOM_PAGER'],
                            'PAGER_TITLE' => $arParams['DETAIL_PAGER_TITLE'],
                            'PAGER_SHOW_ALWAYS' => 'N',
                            'PAGER_TEMPLATE' => $arParams['DETAIL_PAGER_TEMPLATE'],
                            'PAGER_SHOW_ALL' => $arParams['DETAIL_PAGER_SHOW_ALL'],
                            'CHECK_DATES' => $arParams['CHECK_DATES'],
                            'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
                            'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
                            'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
                            'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                            'IBLOCK_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['news'],
                            'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'] ?? '',
                            'STRICT_SECTION_CHECK' => $arParams['STRICT_SECTION_CHECK'] ?? '',
                        ],
                        $component
                    );
                    ?>
              <div class="article__bottom">
                  <div class="article__bottom-products">
                      <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:catalog.section',
                            'recommend',
                            [
                                'IBLOCK_TYPE' => Iblock::getInstance()->getIblockTypeIdByCode('catalog'),
                                'IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('catalog'),
                                'SECTION_TITLE' => 'Продукты из статьи',
                                'FILTER_NAME' => 'FILTER_ARTICLES_PRODUCTS',
                                'SORT_BY1' => 'SORT',
                                'SORT_ORDER1' => 'ASC',
                                'SORT_BY2' => 'NAME',
                                'SORT_ORDER2' => 'ASC',
                                'PAGE_ELEMENT_COUNT' => 4,
                                'FIELD_CODE' => [],
                                'PROPERTY_CODE' => ['FAKE'],
                                'CHECK_DATES' => 'Y',
                                'DETAIL_URL' => '',
                                'AJAX_MODE' => 'N',
                                'CACHE_TYPE' => 'A',
                                'CACHE_TIME' => '36000000',
                                'CACHE_FILTER' => 'N',
                                'CACHE_GROUPS' => 'Y',
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
                            true
                        );
                        ?>
                  </div>
                      <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:news.list',
                            'articles_read_more',
                            [
                            'IBLOCK_TYPE' => 'content',
                            'IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('articles'),
                            'NEWS_COUNT' => 6,
                            'SORT_BY1' => 'SHOW_COUNTER',
                            'SORT_ORDER1' => 'DESC',
                            'SORT_BY2' => 'NAME',
                            'SORT_ORDER2' => 'ASC',
                            'FILTER_NAME' => 'FILTER_ARTICLES_RECENTLY',
                            'FIELD_CODE' => [],
                            'PROPERTY_CODE' => ['FAKE'],
                            'CHECK_DATES' => 'Y',
                            'DETAIL_URL' => '',
                            'AJAX_MODE' => 'N',
                            'CACHE_TYPE' => 'A',
                            'CACHE_TIME' => '36000000',
                            'CACHE_FILTER' => 'N',
                            'CACHE_GROUPS' => 'Y',
                            'PREVIEW_TRUNCATE_LEN' => '',
                            'ACTIVE_DATE_FORMAT' => 'j F Y',
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
                            true
                        );
                        ?>
                  </div>
              </div>
          </div>
    </div>
</div>
