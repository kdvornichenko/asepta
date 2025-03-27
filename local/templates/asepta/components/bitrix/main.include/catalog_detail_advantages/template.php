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
$resize = new Resize(intval($content), [394, 394]);

?>
<?php
echo $resize ->getPictureTag();
