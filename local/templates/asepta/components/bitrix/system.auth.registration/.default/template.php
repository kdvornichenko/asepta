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

$APPLICATION->IncludeComponent(
    'asepta:main.register',
    '',
    [
        'SET_TITLE' => 'Y',
        'USE_CAPTCHA' => 'N',
        'CAPTCHA_PUBLIC' => RECAPTCHA_PUBLIC_KEY,
        'CAPTCHA_PRIVATE' => RECAPTCHA_PRIVATE_KEY,
        'USE_BACKURL' => 'N',
        'AUTH' => 'Y',
        'SHOW_FIELDS' => [
            'NAME',
            'UF_SPECIALIZATION',
            'PERSONAL_CITY',
            'WORK_POSITION',
            'PHONE_NUMBER',
            'EMAIL',
            'PASSWORD',
            'CONFIRM_PASSWORD',


        ],
        'REQUIRED_FIELDS' => [
            'EMAIL',
            'PASSWORD',
            'CONFIRM_PASSWORD',
            'NAME',
        ],
        'AUTH_LINK' => $arResult['AUTH_AUTH_URL'],
    ]
);
