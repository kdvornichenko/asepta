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

$this->setFrameMode(true);

if (empty($arResult['FILE'])) {
    return;
}

$text = $arParams['CUSTOM_VALUE'] ?: file_get_contents($arResult['FILE']);
$number = preg_replace('/[^0-9+]/', '', $text);

if (empty($number)) {
    return;
}

?>
<a class="header__right-tel" href="tel:<?=$number?>">
    <?=htmlspecialchars($text)?>
</a>
