<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;

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

$this->setFrameMode(false);
$request = Context::getCurrent()->getRequest();

?>
<div class="page__body container">
    <div class="profile">
        <div class="profile__main">
            <?php $APPLICATION->IncludeComponent(
                'asepta:main.profile',
                '.default',
                [
                    'CHECK_RIGHTS' => 'Y',
                    'USER_FIELDS' => [
                        'NAME',
                        'LAST_NAME',
                        'PERSONAL_BIRTHDAY',
                        'EMAIL',
                        'PERSONAL_PHONE',
                        'UF_RING_SIZE_THUMB',
                        'UF_RING_SIZE_FOREFINGER',
                        'UF_RING_SIZE_MIDDLE',
                        'UF_RING_SIZE_RINGFINGER',
                        'UF_RING_SIZE_LITTLE',
                        'UF_CLOTHES_SIZE_TOP',
                        'UF_CLOTHES_SIZE_BOTTOM',
                    ],
                    'USER_FIELDS_REQUIRED' => [
                        'NAME',
                        'EMAIL',
                        'PERSONAL_PHONE',
                    ],
                ],
                false,
                ['HIDE_ICONS' => 'Y']
            )?>

        </div>
    </div>
</div>
