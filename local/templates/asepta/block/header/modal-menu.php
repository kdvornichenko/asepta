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
<div class="modal-menu__nav">
    <div class="modal-menu__list">
        <?php
            $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "modal-menu",
                array(
                    "ROOT_MENU_TYPE" => "footer_sections",
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
                    "MENU_TITLE" => "Категории"
                ),
                false
            );
            ?>
    </div>
    <div class="modal-menu__list">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "modal-menu",
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
    <?php
    $APPLICATION->IncludeComponent(
        'bitrix:main.include',
        'menu_products_link',
        [
                    'AREA_FILE_SHOW' => 'file',
                    'PATH' => SITE_TEMPLATE_PATH . '/include_area/' . SITE_ID . '/menu_products_link.php',
                ],
        true
    );
    ?>
   </div>
<div class="modal-menu__categories">
    <div class="modal-menu__title"><?= Loc::getMessage('MENU_MODAL_TITLE') ?></div>
    <?php
    $GLOBALS['CATEGORIES_MENU_FILTER'] = ['PROPERTY_SHOW_IN_MENU_VALUE' => 'Y'];
        $APPLICATION->IncludeComponent(
            'bitrix:news.list',
            'categories_main_menu',
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
</div>
