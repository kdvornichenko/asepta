<?php

use Its\Library\Image\Resize;
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

$this->setFrameMode(true);

if (empty($arResult['ITEMS'])) {
    return;
}
?>
<div class="products__cards">
    <?php
    foreach ($arResult['ITEMS'] as $key => $itemData) {
        $resize = new Resize(
            intval($itemData['PROPERTIES']['MOBILE_PICTURE']['VALUE']),
            [656, 240],
            BX_RESIZE_IMAGE_EXACT,
            [Resize::SHARPEN_OFF]
        );
        ?>
        <a class="products__card" href="<?= $itemData['PROPERTIES']['LINK']['VALUE'] ?>">
            <div class="products__card-title"><?=$itemData['PROPERTIES']['TITLE']['~VALUE']?></div>
            <div class="products__card-img__holder">
                <?php
                echo $resize->getPictureTag([
                    'img_class' => 'products__card-img'
                ]);
                ?>
            </div>
        </a>
        <?php
    }
    ?>
</div>
