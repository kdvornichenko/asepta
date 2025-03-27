<?php

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

?>
<ul class="filters">
        <?php
        foreach ($arResult['URLS'] as $arUrl) {
            ?>
            <li class="filters__item">
                <a <?= $arUrl['ACTIVE'] == 'Y' ? 'class="is-active"' : '' ?>
                    href="<?= $arUrl['URL'] ?>">
                    <?= $arUrl['NAME'] ?>
                </a>
            </li>
            <?php
        }
        ?>
</ul>
