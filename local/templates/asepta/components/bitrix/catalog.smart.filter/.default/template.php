<?php

use Bitrix\Main\Context;
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

?>
<div class="modal__content">
    <div class="modal-filters">
        <button class="modal-filters__close" type="button" data-modal-close="filters">
            <svg class="i-cross">
                <use xlink:href="#cross"></use>
            </svg>
        </button>
        <form  id="<?= $arResult['FILTER_NAME'] ?>_form" class="modal-filters__form" data-filters data-form="filters" action="<?= $arResult['FORM_ACTION'] ?>">
            <div class="modal-filters__head">
                <?= Loc::getMessage('MART_FILTER_TITLE') ?>
            </div>

            <?php
            usort($arResult['ITEMS'], function ($a, $b) {
                if ($a['PRICE'] === $b['PRICE']) {
                    return 0;
                }
                return ($a['PRICE'] === true) ? -1 : 1;
            });

            foreach ($arResult['ITEMS'] as $itemData) {
                if ($itemData['PROPERTY_TYPE'] === 'E') {
                    continue;
                }

                if ($itemData['PRICE'] === true) {
                    $itemData['DISPLAY_TYPE'] = 'A';
                }

                if (empty($itemData['VALUES'])) {
                    continue;
                }

                if ($itemData['DISPLAY_TYPE'] == 'A' && ($itemData['VALUES']['MAX']['VALUE'] - $itemData['VALUES']['MIN']['VALUE'] <= 0)) {
                    continue;
                }

                // Calendar date
                if ($itemData['DISPLAY_TYPE'] == 'U') {
                    continue;
                }

                switch ($itemData['DISPLAY_TYPE']) {
                    case 'A': // Number with range slider (or price)
                    case 'B': // Number inputs
                    case 'G': // Checkboxes with picture
                    case 'H': // Checkboxes with picture and label
                    case 'P': // Select (radio drop)
                    case 'R': // Select (radio drop) with picture and label
                    case 'K': // Radio
                        break;
                    default:
                        ?>
                         <fieldset class="modal-filters__form-list">
                        <?php
                        foreach ($itemData['VALUES'] as $valueData) {
                            ?>
                            <div class="modal-filters__form-checkbox">
                                <input
                                    type="checkbox"
                                    id="<?=$valueData['CONTROL_ID']?>"
                                    name="<?=$valueData['CONTROL_NAME']?>"
                                    data-name="<?=$valueData['VALUE']?>"
                                    value="<?=$valueData['HTML_VALUE']?>"
                                    class="jsFilterItem <?=($valueData['DISABLED'] ? 'disabled' : '')?>"
                                    onchange="window.smartFilter.change(this)"
                                    <?=($valueData['CHECKED'] ? 'checked' : '')?>
                                />
                                <label  for="<?= $valueData['CONTROL_ID'] ?>"> <?= $valueData['VALUE'] ?></label>
                            </div>
                            <?php
                        }
                        ?>
                     </fieldset>
                        <?php
                }
            }
            ?>
            <fieldset class="modal-filters__form-btns">
                <button class="btn btn--outline jsSmartFilterReload"
                        data-reset-filters
                        type="button">
                    <span class="btn__text">
                        <?=Loc::getMessage('SMART_FILTER_RESET') ?>
                    </span>
                </button>
                <button class="btn btn--fill" data-apply-filters data-modal-close="filters" id="jsSmartFilterApplyButton">
                    <span class="btn__text">
                        <?=Loc::getMessage('SMART_FILTER_APPLY') ?>
                    </span>
                </button>
            </fieldset>
        </form>
    </div>
</div>

<?php
$filterParams = [
    'selector' => '.jsFilterItem',
    'applyButton' => 'jsSmartFilterApplyButton',
];

if ($arParams['~STATIC_VALUES']) {
    $filterParams['staticValues'] = $arParams['~STATIC_VALUES'];
}

if (is_array($arResult['JS_FILTER_PARAMS'])) {
    $arResult['JS_FILTER_PARAMS'] = array_merge($arResult['JS_FILTER_PARAMS'], $filterParams);
} else {
    $arResult['JS_FILTER_PARAMS'] = $filterParams;
}
?>


<script data-parse>
    document.addEventListener('DOMContentLoaded', function () {

        document.getElementById('jsSmartFilterApplyButton').addEventListener('click', function (event) {
            event.preventDefault();
            window.lastAction = 'apply';
            let url = this.getAttribute('data-url');
            if (!this.hasAttribute('disabled') && !!url) {
                history.pushState('', '', url);
                document.dispatchEvent(new CustomEvent('custom_section_filter_apply', {
                    detail: {url: url}
                }));

            }
        });
        document.addEventListener('click', function (event) {
            if (Tool.closest(event.target, '.jsSmartFilterReload')) {
                window.lastAction = 'reload';
            }
        });
        window.smartFilter = new CatalogSmartFilter(
            <?=json_encode($arResult['FORM_ACTION'])?>,
            <?=json_encode("{$arResult['FILTER_NAME']}_form")?>,
            <?=json_encode($arResult['JS_FILTER_PARAMS'])?>,
            (url, result) => {
                if (window.lastAction === 'reload') {
                    window.lastAction = '';
                    history.pushState('', '', url);
                    document.dispatchEvent(new CustomEvent('custom_section_filter_apply', {
                        detail: {url: url, result: result}
                    }));
                }
            }
        );
    });
</script>
