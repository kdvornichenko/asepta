<?php

use Bitrix\Main\Localization\Loc;

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

$this->setFrameMode(true);

if (!$arResult['SECTIONS_COUNT']) {
    return;
}
$cur_page = $arParams["URL"];
$is_active = false;
?>
<ul class="filters">
    <li class="filters__item">
        <a class="<?= $cur_page == "/catalog/" ? "is-active" : ""?>" href="/catalog/">
            <?= Loc::getMessage('CATEGORIES_VIEW_ALL') ?>
        </a>
    </li>
    <?php
    foreach ($arResult['SECTIONS'] as $arSection) {
        $cur_page == $arSection['SECTION_PAGE_URL'] ? $is_active = true : $is_active = false;
        ?>
        <li class="filters__item">
            <a class="<?=($is_active) ? 'is-active' : ''?>"
               href="<?= $arSection['SECTION_PAGE_URL'] ?>">
                <?= $arSection['NAME'] ?>
            </a>
        </li>
        <?php
    }
    ?>
</ul>
