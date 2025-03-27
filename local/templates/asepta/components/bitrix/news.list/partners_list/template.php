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
}?>
<div class="buy-body__filters">
<ul class="filters">
    <li class="filters__item">
        <input type="radio" name="filters-radio" id="filters-radio--1" data-filter="reset" checked="checked">
        <label for="filters-radio--1"><?= Loc::getMessage('BRANDS_LIST_ALL') ?></label>
    </li>
    <?php
    foreach ($arResult['ITEMS'] as $key => $arSection) {
        ?>
        <li class="filters__item">
            <input type="radio"
                   name="filters-radio"
                   id="filters-radio--<?= $key + 2 ?>"
                   data-filter="<?= $arSection["CODE"] ?>">
            <label for="filters-radio--<?= $key + 2 ?>"><?= $arSection["NAME"] ?></label>
        </li>
        <?php
    }
    ?>
</ul>
</div>
<div class="buy-blocks">
<?php
foreach ($arResult['ITEMS'] as $key => $arSection) {
    ?>
    <div class="buy-block" data-filter-target="<?= $arSection["CODE"] ?>">
        <h2><?= $arSection["NAME"] ?></h2>
        <div class="buy-block__items">
            <?php
            foreach ($arSection['ELEMENTS'] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                $resize = new Resize(
                    (int)$arItem["PROPERTIES"]["LOGO_SVG"]["VALUE"],
                    [249, 97],
                    BX_RESIZE_IMAGE_PROPORTIONAL
                );
                ?>
                <div class="buy-block__item" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                    <a class="partner" href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>" target="_blank">
                        <div class="partner__img-holder">
                            <?php
                            echo $resize->getPictureTag(
                                [
                                    'alt' => htmlspecialchars($arItem['NAME']),
                                    'img_class' => 'partner__img'
                                ]
                            );?>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
            <?php
}
?>
</div>
