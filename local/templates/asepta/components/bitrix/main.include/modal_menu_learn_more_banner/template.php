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
$resize = new Resize(intval($lines[3]), [500, 500]);

if (empty($title) || empty($buttonName) || empty($buttonLink)) {
    return;
}

?>
<div class="modal-learn-more__image">
    <?php
    echo $resize->getPictureTag();
    ?>
</div>
<div class="modal-learn-more__banner-content">
    <h4><?= $title ?></h4>
    <a href="<?= $buttonLink ?>">
        <button class="btn"><span class="btn__text">
                <?= $buttonName ?></span>
        </button>
    </a>
</div>
