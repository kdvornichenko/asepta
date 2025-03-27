<?php

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
/** @var CIBlockResult $navResult */

$this->setFrameMode(true);

if (empty($arResult['ITEMS'])) {
    return;
}
?>
    <div class="catalog-body__list jsCatalogSectionElementListWrap">
        <?php
        foreach ($arResult['ITEMS'] as $arItem) {
            if ($arItem['TYPE'] == 'banner') {
                $APPLICATION->IncludeComponent(
                    'asepta:catalog.item',
                    'banner',
                    [
                        'CURRENT_FILTER' => $arParams['CURRENT_FILTER'],
                        'ITEM' => $arItem,
                        'AREA_ID' => $this->GetEditAreaId($arItem['ID']),
                    ],
                    $component,
                    ['HIDE_ICONS' => 'Y']
                );
            } else {
                 $APPLICATION->IncludeComponent(
                     'asepta:catalog.item',
                     '',
                     [
                        'CURRENT_FILTER' => $arParams['CURRENT_FILTER'],
                        'ITEM' => $arItem,
                        'AREA_ID' => $this->GetEditAreaId($arItem['ID']),
                        'USE_SMART_FILTER' => $arParams['USE_SMART_FILTER']
                     ],
                     $component,
                     ['HIDE_ICONS' => 'Y']
                 );
            }
        }
        ?>
</div>
<?php
$this->SetViewTarget('catalog_pagination');
if ($arParams['DISPLAY_BOTTOM_PAGER']) {
    echo $arResult['NAV_STRING'];
}
$this->EndViewTarget();
