<?php

use Bitrix\Main\Localization\Loc;

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

/*
 * NAV_ID - NavNum
 * IS_DESC_NUMBERING - bDescPageNumbering
 * NAV_PAGE_SIZE - NavPageSize
 * NAV_PAGE_START - nStartPage
 * NAV_PAGE_END - nEndPage
 * NAV_PAGE_CURRENT - NavPageNomer
 * NAV_PAGE_COUNT - NavPageCount
 * NAV_PATH - sUrlPath / NavQueryString
 * NAV_QUERY_TO - sUrlPath / NavQueryString / PAGEN_ / NavNum
 */

$this->setFrameMode(true);

if ($arResult['NAV_PAGE_COUNT'] < 2) {
    return;
}

?>
    <?php
    if ($arResult['NAV_PAGE_CURRENT'] < $arResult['NAV_PAGE_COUNT']) {
        ?>
        <a class="btn btn--outline jsPageNavigationShowMoreButton"
           href="<?=$arResult['NAV_QUERY_TO'] . ($arResult['NAV_PAGE_CURRENT'] + 1)?>">
            <span class="btn__text"><?=Loc::getMessage('PAGE_NAVIGATION_TEMPLATE_SHOW_MORE')?></span>
        </a>
        <?php
    }
    ?>
