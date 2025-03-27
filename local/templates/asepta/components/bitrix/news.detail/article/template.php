<?php

use Bitrix\Main\Localization\Loc;
use Its\Library\Image\Resize;
use Its\Library\Iblock\Iblock;
use Its\Library\Tool\Declension;

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

$GLOBALS['FILTER_ARTICLES_RECENTLY'] = [
    '!ID' => $arResult['ID']
];
$GLOBALS['FILTER_ARTICLES_PRODUCTS'] = [
    'ID' => $arResult['PROPERTIES']['PRODUCTS']['VALUE'] ?: false,
];

$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
$resizeExpert = new Resize(intval($arResult ['PROPERTIES']['EXPERT_DATA']['PREVIEW_PICTURE']), [80, 80]);
$resizeBanner = new Resize(intval($arResult ['PROPERTIES']['BANNER_DETAIL']['VALUE']), [2070, 1380]);
$resizeProduct = new Resize(intval($arResult['PROPERTIES']['PRODUCT_IN_CONTENT_DATA']['PREVIEW_PICTURE']), [840, 620]);

$this->SetViewTarget('articles_top_banner');
if ($resizeBanner->isSuccess()) {
    ?>
    <div class="article__top-img__holder">
    <?php
        echo $resizeBanner->getPictureTag([
            'alt' => htmlspecialchars($arResult['NAME']),
            'img_class' => 'article__top-img'
        ]);
    ?>
    </div>
    <?php
}
$this->EndViewTarget();
?>
<div class="article__body">
    <div class="article__title">
        <h1><?= $arResult['NAME'] ?></h1>
    </div>
    <div class="article__author">
        <div class="article__author-inner">
            <div class="article__author-top"></div>
            <div class="article__author-descr"><?= Loc::getMessage('ARTICLES_DETAIL_CATEGORY') ?></div>
            <div class="article__author-top__text"><?=$arResult['SECTION']['PATH'][0]['NAME']?></div>
            <div class="article__author-content">
                <div class="article__author-descr"><?= Loc::getMessage('ARTICLES_DETAIL_AUTOR') ?></div>
                <div class="article__author-img__holder">
                    <?php
                    if ($resizeExpert->isSuccess()) {
                        echo $resizeExpert->getPictureTag(
                            [
                                'alt' => htmlspecialchars($arResult['NAME']),
                                'img_class' => 'article__author-img',
                            ]
                        );
                    }?>
                </div>
                <div class="article__author-name"><?=$arResult['PROPERTIES']['EXPERT_DATA']['NAME']?></div>
                <div class="article__author-text"><?=$arResult['PROPERTIES']['EXPERT_DATA']['PREVIEW_TEXT']?></div>
            </div>
        </div>
    </div>
        <div class="article__content">
            <p class="article__text-big">
                <?=$arResult['~DETAIL_TEXT']?>
            </p>
            <div class="article__product">
                <a class="product-card" href="<?=$arResult['PROPERTIES']['PRODUCT_IN_CONTENT_DATA']['NAME']?>">
                    <div class="product-card__image">
                        <?php
                        if ($resizeExpert->isSuccess()) {
                            echo $resizeProduct->getPictureTag([
                                'alt' => htmlspecialchars($arResult['NAME']),
                            ]);
                        }
                        ?>
                    </div>
                    <div class="product-card__info"> </div>
                    <button class="btn btn--icon btn--icon-big">
                        <svg class="i-arrow-up-right">
                            <use xlink:href="#arrow-up-right"></use>
                        </svg>
                    </button>
                </a>
                <div class="article__product-content">
                    <div class="article__product-content__title">
                        <?=$arResult['PROPERTIES']['PRODUCT_IN_CONTENT_DATA']['PROPERTY_BLACK_TITLE_VALUE']?>
                    </div>
                    <div class="article__product-content__descr">
                        <?=$arResult['PROPERTIES']['PRODUCT_IN_CONTENT_DATA']['PROPERTY_GREY_TITLE_VALUE']?>
                    </div>
                    <div class="article__product-content__text">
                        <?=$arResult['PROPERTIES']['PRODUCT_IN_CONTENT_DATA']['PREVIEW_TEXT']?>
                    </div>
                </div>
            </div>
            <?php
            if ($arResult['PROPERTIES']['DETAIL_TEXT_2']['~VALUE']) {
                echo $arResult['PROPERTIES']['DETAIL_TEXT_2']['~VALUE']['TEXT']?>
                <?php
            }
            if ($arResult['PROPERTIES']['SOURCES']['VALUE']) {
                ?>
                <h2><?= Loc::getMessage('ARTICLES_DETAIL_SOURCES') ?></h2>
                <ol class="article__list-big">
                    <?=$arResult['PROPERTIES']['SOURCES']['~VALUE']['TEXT']?>
                </ol>
                <?php
            }
            ?>
        </div>
    </div>
