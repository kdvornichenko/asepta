<?php

use Bitrix\Main\Localization\Loc;
use Its\Library\Iblock\Iblock;

/**
 * @global $APPLICATION;
 */


if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

?>
<div class="modal-mobile-menu__content">
    <div class="search modal-mobile-menu__search">
        <div class="search__input">
            <label for="search-dektop">
                <svg class="i-search">
                    <use xlink:href="#search"></use>
                </svg>
            </label>
            <input type="text" placeholder="Поиск по разделу" id="search-dektop" name="search">
        </div>
    </div>
    <ul class="modal-mobile-menu__list">
    <li class="modal-mobile-menu__item" data-acc>
        <button class="btn modal-mobile-menu__acc-btn is-active" data-acc-btn="menu-item">
            <svg class="i-arrow-down">
                <use xlink:href="#arrow-down"></use>
            </svg><span class="btn__text"><?= Loc::getMessage('MENU_MOBILE_CATALOG_TITLE') ?></span>
        </button>
        <div class="modal-mobile-menu__acc-content is-open" data-acc-content="menu-item">
            <div data-acc-content-inner>
                <div class="products__top-container">
                    <div class="products__header">
                        <?= Loc::getMessage('MENU_MOBILE_CATEGORIES_TITLE') ?>
                    </div>
                    <button class="btn products__see-all">
                        <a class="products__see-all" href="/catalog/">
                            <?= Loc::getMessage('MENU_MOBILE_CATALOG_VIEW_ALL') ?>
                        </a>
                    </button>
                </div>

                    <?php
                    $GLOBALS['CATEGORIES_MENU_FILTER'] = ['PROPERTY_SHOW_IN_MENU_VALUE' => 'Y'];
                    $APPLICATION->IncludeComponent(
                        'bitrix:news.list',
                        'categories_main_menu_mobile',
                        [
                            'IBLOCK_TYPE' => 'content',
                            'IBLOCK_ID' => Iblock::getInstance()->getIblockIdByCode('categories'),
                            'NEWS_COUNT' => 4,
                            'SORT_BY1' => 'SORT',
                            'SORT_ORDER1' => 'ASC',
                            'SORT_BY2' => 'ACTIVE_FROM',
                            'SORT_ORDER2' => 'DESC',
                            'FILTER_NAME' => 'CATEGORIES_MENU_FILTER',
                            'FIELD_CODE' => [],
                            'PROPERTY_CODE' => ['FAKE'],
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
                <div class="products__nav">
                    <div class="products__list">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "modal-menu-appointments",
                            array(
                                "ROOT_MENU_TYPE" => "appointments",
                                "MAX_LEVEL" => "1",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "COMPONENT_TEMPLATE" => "modal-menu",
                                "CHILD_MENU_TYPE" => "",
                                "USE_EXT" => "N",
                                "MENU_TITLE" => "Назначения"
                            ),
                            false
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="modal-mobile-menu__item">
        <div class="modal-mobile-menu__item-header">
            <a href="/doctors/">
                <?= Loc::getMessage('MENU_MOBILE_DOCTORS_TITLE') ?>
            </a>
        </div>
    </li>
    <li class="modal-mobile-menu__item" data-acc>
        <button class="btn modal-mobile-menu__acc-btn" data-acc-btn="menu-item">
            <svg class="i-arrow-down">
                <use xlink:href="#arrow-down"></use>
            </svg>
            <span class="btn__text">
                <?= Loc::getMessage('MENU_MOBILE_LEARN_MORE_TITLE') ?>
            </span>
        </button>
        <div class="modal-mobile-menu__acc-content" data-acc-content="menu-item">
            <div data-acc-content-inner>
                <div class="learn-more__nav">
                    <div class="modal-learn-more__list">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "modal-menu",
                            array(
                                "ROOT_MENU_TYPE" => "learn_more_1",
                                "MAX_LEVEL" => "1",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "COMPONENT_TEMPLATE" => "modal-menu",
                                "CHILD_MENU_TYPE" => "",
                                "USE_EXT" => "N",
                                "MENU_TITLE" => ""
                            ),
                            false
                        );
                        ?>
                    </div>
                    <div class="modal-learn-more__list">
                        <?php
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "modal-menu",
                            array(
                                "ROOT_MENU_TYPE" => "learn_more_2",
                                "MAX_LEVEL" => "1",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "COMPONENT_TEMPLATE" => "modal-menu",
                                "CHILD_MENU_TYPE" => "",
                                "USE_EXT" => "N",
                                "MENU_TITLE" => ""
                            ),
                            false
                        );
                        ?>
                    </div>
                </div>
                <div class="learn-more__card-wrapper">
                    <?php $APPLICATION->IncludeComponent(
                        'bitrix:main.include',
                        'modal_menu_mobile_banner',
                        [
                            'AREA_FILE_SHOW' => 'file',
                            'PATH' => SITE_TEMPLATE_PATH . '/include_area/' . SITE_ID . '/menu_brands_info.php',
                        ],
                        true
                    );?>

                </div>
            </div>
        </div>
    </li>
    <li class="modal-mobile-menu__item">
        <div class="modal-mobile-menu__item-header">
            <a href="/buy/">
                <?= Loc::getMessage('MENU_MOBILE_WHERE_TO_BUY') ?>
            </a>
        </div>
    </li>
    </ul>
</div>
<div class="modal-mobile-menu__phone">
    <?php $APPLICATION->IncludeComponent(
        'bitrix:main.include',
        'modal_phone',
        [
            'AREA_FILE_SHOW' => 'file',
            'PATH' => SITE_TEMPLATE_PATH . '/include_area/' . SITE_ID . '/template_phone.php',
        ],
        true
    );?>
</div>
