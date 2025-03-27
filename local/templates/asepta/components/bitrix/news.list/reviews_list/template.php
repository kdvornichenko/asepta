<?php

use Its\Library\Image\Resize;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\DateTime;

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
<div class="reviews-body__list">
    <?php
    foreach ($arResult['ITEMS'] as $index => $itemData) {
        ?>
        <div class="review-item" data-review-item>
            <div class="review-item__head">
                <div class="review-item__main">
                    <div class="review-item__main-img">
                        <?php
                        $resizePartnerLogo = new Resize(
                            (int)$itemData['PROPERTIES']['PARTNER_DATA']['PROPERTY_LOGO_CIRCLE_VALUE'],
                            [200, 200]
                        );
                        if ($resizePartnerLogo->isSuccess()) {
                            echo $resizePartnerLogo->getPictureTag([
                                'alt' => htmlspecialchars($itemData['PROPERTIES']['PARTNER_DATA']['NAME']),
                            ]);
                        }
                        ?>
                    </div>
                    <div class="review-item__main-info">
                        <p><?= $itemData['NAME'] ?></p>
                        <span><?=(new DateTime($itemData['DATE_ACTIVE_FROM']))->format('d.m.Y')?></span>
                    </div>
                </div>
                <div class="review-item__rating">
                 <?php
                    for ($i = 1; $i <= $itemData['PROPERTIES']['RATING']['VALUE']; $i++) {
                        ?>
                    <div class="review-item__rating-item">
                        <svg class="i-tooth">
                            <use xlink:href="#tooth"></use>
                        </svg>
                    </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <p data-review-item-text> <?= $itemData['PREVIEW_TEXT'] ?></p>
            <div class="review-item__read-more"><?=Loc::getMessage('REVIEWS_LIST_READ_MORE')?></div>
            <div class="review-item__gallery">
               <?php
                foreach ($itemData['PROPERTIES']['IMAGES']['VALUE'] as $galleryItem) {
                    $resize = new Resize((int)$galleryItem, [400, 400]);
                    if ($resize->isSuccess()) {
                        ?>
                        <div class="review-item__gallery-item">
                        <?php
                        echo $resize->getPictureTag([
                        'alt' => htmlspecialchars($itemData['NAME']),
                        'lazy' => 'true',
                        'img_class' => 'lazyload',
                        ]);
                        ?>
                        </div>
                        <?php
                    }
                } ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>
