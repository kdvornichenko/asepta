<?php

use Bitrix\Main\Localization\Loc;
use Its\Library\Image\Resize;

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

$content = preg_replace('/[\n\r]+/', PHP_EOL, file_get_contents($arResult['FILE']));
$lines = explode(PHP_EOL, $content);

$title = $lines[0];
$buttonName = $lines[1];
$buttonLink = $lines[2];
$resizeMobile = new Resize(intval($lines[4]), [394, 394]);

if (empty($title) || empty($buttonLink)) {
    return;
}

?>
<a class="learn-more__card" href="<?= $buttonLink ?>">
    <div class="learn-more__card-title"><?= $title ?></div>
    <div class="learn-more__card-img__holder">
        <?php
        echo $resizeMobile->getPictureTag();
        ?>
    </div>
</a>
