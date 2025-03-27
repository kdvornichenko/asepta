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

$content = preg_replace('/[\n\r]+/', PHP_EOL, file_get_contents($arResult['FILE']));
$lines = explode(PHP_EOL, $content);

// 0 - Заголовок блока
// 1 - Ссылка
// 2 - Изображение(передний план)
// 3 - Изображение(задний план)
// 4 - Цвет заголовка
// 5 - Цвет фона

$resize = new Resize(intval($lines[2]), [608, 512]);
$colorBackground = $lines[4];
$colorTitle = $lines[5];
?>
<a class="main-links__item"
   href="<?= $lines[1] ?>"
    <?php if ($colorBackground) { ?>
        style="background:<?= $colorBackground ?>"
        <?php
    } ?>>
    <p <?php if ($colorTitle) {?>
        style="color:<?= $colorTitle ?>"
        <?php
       } ?>>
        <?= $lines[0] ?>
    </p>
    <div class="main-links__item-img"
         data-parallax="slideLeft slideTop"
         data-parallax-end="center bottom"
         data-parallax-translatex="20%">
        <?php
        if ($lines[2]) {
            echo $resize->getPictureTag();
        }
        ?>
    </div>
    <div class="main-links__icon">
        <button class="btn btn--icon btn--icon-big">
            <svg class="i-arrow-up-right">
                <use xlink:href="#arrow-up-right"></use>
            </svg>
        </button>
    </div>
</a>
