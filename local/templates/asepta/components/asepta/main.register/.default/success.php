<?php

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

?>
<main>
    <?php $APPLICATION->IncludeComponent(
        'bitrix:breadcrumb',
        '',
        [
            'PATH' => '',
            'SITE_ID' => SITE_ID,
            'START_FROM' => 0,
        ],
        false,
        ['HIDE_ICONS' => 'Y']
    )?>
    <section class="section container success-page">
        <div class="success-page__content">
            <?php
            if ($arResult['USE_EMAIL_CONFIRMATION'] === 'Y') {
                ?>
                <div class="success-page__head">
                    <h1 class="t-h2 success-page__title">
                        <?php $APPLICATION->ShowTitle(false)?>
                    </h1>
                </div>
                <div class="block notification">
                    <picture>
                        <img class="notification__icon" src="/assets/img/svg/sms-star.svg" alt="" width="56" height="56">
                    </picture>
                    <div class="notification__text">
                        <?=Loc::getMessage('REGISTER_SUCCESS_CONFIRM_MESSAGE')?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="success-page__head">
                    <h1 class="t-h2 success-page__title success-page__title--success">
                        <?php $APPLICATION->ShowTitle(false)?>
                    </h1>
                </div>
                <div class="block notification">
                    <picture>
                        <img class="notification__icon" src="/assets/img/svg/emoji-happy.svg" alt="" width="56" height="56">
                    </picture>
                    <div class="notification__title">
                        <?=Loc::getMessage('REGISTER_SUCCESS_DONE_TITLE')?>
                    </div>
                    <div class="notification__text-min">
                        <?=Loc::getMessage('REGISTER_SUCCESS_DONE_MESSAGE')?>
                    </div>
                    <a class="btn notification__link" href="<?=$arParams['AUTH_LINK']?>">
                        <span class="btn__text">
                            <?=Loc::getMessage('REGISTER_SUCCESS_DONE_AUTH')?>
                        </span>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</main>
