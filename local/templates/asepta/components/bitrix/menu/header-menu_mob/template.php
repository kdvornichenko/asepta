<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult as $key => $menuItem) {
    ?>
    <div class="inner-menu__item js-inner-menu-item-main" style="transform: translateX(-100%); opacity: 0">
        <span><?=($key < 9 ? '0' . ($key + 1) : ($key + 1))?></span>
        <a href="<?=$menuItem['LINK']?>" class="inner-menu__descr">
            <span><?=$menuItem['TEXT']?></span>
        </a>
    </div>
    <?php
}

?>
<!--<div class="inner-menu__compare js-inner-menu-item-main" style="transform: translateX(-100%); opacity: 0">
    <a href="/catalog/compare/" class="inner-menu__compare-link">
        <div class="icon-compare">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="inner-menu__compare-text">Сравнение</div>
    </a>
</div>-->
