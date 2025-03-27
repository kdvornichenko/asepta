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
<div class="modal-menu__cards modal-menu__cards--<?= count($arResult['ITEMS']) ?>">
    <?php
    foreach ($arResult['ITEMS'] as $key => $itemData) {
        $resize = new Resize(
            intval($itemData['~PREVIEW_PICTURE']),
            [444, 705],
            BX_RESIZE_IMAGE_EXACT,
            [Resize::SHARPEN_OFF]
        );
        ?>
        <a class="modal-menu__card" href="<?= $itemData['PROPERTIES']['LINK']['VALUE'] ?>">
            <div class="modal-menu__card-title"> <?=$itemData['PROPERTIES']['TITLE']['~VALUE']?></div>
            <div class="modal-menu__card-img__holder">
                <?php
                echo $resize->getPictureTag([
                    'img_class' => 'modal-menu__card-img'
                ]);
                ?>
            </div>
            <div class="modal-menu__card-btn">
                <?= Loc::getMessage('MENU_CATEGORIES_SHOW_MORE') ?>
            </div>
        </a>
        <?php
    }
    ?>
</div>
