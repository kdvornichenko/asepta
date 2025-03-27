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
$editParams = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');

?>
<div class="articles__cards jsArticlesSectionElementListWrap">
    <?php
    foreach ($arResult['ITEMS'] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $editParams);
        $resize = new Resize(intval($arItem['~PREVIEW_PICTURE']), [800, 972]);
        $resizeBigImage = new Resize(intval($arItem ['PROPERTIES']['BANNER']['VALUE']), [4096, 2731]);
        if ($arItem ['PROPERTIES']['SHOW_BANNER']['VALUE'] == 'Y') {
            ?>
            <a class="articles__card--main articles__card"
               href="<?=$arItem['DETAIL_PAGE_URL']?>"
               id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                <div class="articles__card-img__holder">
                <?php
                if ($arItem['SECTION']) {
                    ?>
                    <div class="articles__card-img__label"><?= $arItem['SECTION'] ?></div>
                    <?php
                }
                    echo $resizeBigImage->getPictureTag(
                        [
                            'alt' => htmlspecialchars($arItem['NAME']),
                            'img_class' => 'articles__card-img'
                        ]
                    );?>
                </div>
                <div class="articles__card-info">
                <?php
                if ($arItem['SECTION']) {
                    ?>
                    <div class="articles__card-info__label"><?= $arItem['SECTION'] ?></div>
                    <?php
                }
                ?>
                    <div class="articles__card-info__title"><?=$arItem['NAME']?></div>
                    <div class="articles__card-info__descr"><?=$arItem['PREVIEW_TEXT']?></div>
                    <button class="btn articles__card-info__btn btn--outline">
                        <span class="btn__text"><?= Loc::getMessage('ARTICLES_READ_MORE') ?></span>
                    </button>
                </div>
            </a>
            <?php
        } else {
            ?>
            <a class="articles__card"
               href="<?=$arItem['DETAIL_PAGE_URL']?>"
               id="<?=$this->GetEditAreaId($arItem['ID'])?>">
                <div class="articles__card-img__holder">
                    <?php
                    if ($arItem['SECTION']) {
                        ?>
                    <div class="articles__card-img__label"><?= $arItem['SECTION'] ?></div>
                        <?php
                    }
                    echo $resize->getPictureTag(
                        [
                            'alt' => htmlspecialchars($arItem['NAME']),
                            'img_class' => 'articles__card-img'
                        ]
                    );?>
                </div>
                <div class="articles__card-info">
                    <div class="articles__card-info__title"><?=$arItem['NAME']?></div>
                    <div class="articles__card-info__descr"><?=$arItem['PREVIEW_TEXT']?></div>
                </div>
            </a>
            <?php
        }
    }

    $this->SetViewTarget('articles_pagination');
    if ($arParams['DISPLAY_BOTTOM_PAGER']) {
        echo $arResult['NAV_STRING'];
    }
    $this->EndViewTarget();
