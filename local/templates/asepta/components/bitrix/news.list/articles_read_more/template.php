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

if (empty($arResult['ITEMS'])) {
    return;
}

?>
<div class="article__bottom-articles">
    <div class="article__bottom-articles__inner">
        <h2><?=Loc::getMessage('ARTICLES_READ_MORE_TITLE') ?></h2>
        <div class="swiper article__bottom-articles__slider" data-slider-article="mobile-full" data-width-init="1024">
            <div class="swiper-wrapper">
                    <?php
                    foreach ($arResult['ITEMS'] as $itemData) {
                        $this->AddEditAction($itemData['ID'], $itemData['EDIT_LINK'], $editParams);
                        $resize = new Resize(intval($itemData['~PREVIEW_PICTURE']), [369, 339], BX_RESIZE_IMAGE_EXACT, [Resize::SHARPEN_OFF]);
                        ?>
                        <div class="swiper-slide">
                            <a class="articles__card" href="<?= $itemData['DETAIL_PAGE_URL'] ?>"  id="<?= $this->GetEditAreaId($itemData['ID']) ?>">
                                <div class="articles__card-img__holder">
                                    <?php
                                    if ($itemData['SECTION']) {
                                        ?>
                                    <div class="articles__card-img__label"><?= $itemData['SECTION'] ?></div>
                                        <?php
                                    }
                                    ?>
                                    <?= $resize->getPictureTag([
                                        'alt' => htmlspecialchars($itemData['NAME']),
                                    ]) ?>
                                </div>
                                <div class="articles__card-info">
                                    <div class="articles__card-info__title"><?= $itemData['NAME'] ?></div>
                                    <div class="articles__card-info__descr"><?= $itemData['PREVIEW_TEXT'] ?></div>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
            </div>
            <div class="swiper-scrollbar" data-slider-scrollbar></div>
        </div>
    </div>
    <a class="btn btn--outline article__bottom-articles__btn" href="<?= $arResult["LIST_PAGE_URL"] ?>">
        <span class="btn__text"><?=Loc::getMessage('ARTICLES_READ_MORE_SHOW_ALL') ?></span>
    </a>
</div>
