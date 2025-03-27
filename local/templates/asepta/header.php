<?php

use Bitrix\Main\Localization\Loc;
use Its\Library\Asset\AssetManager;
use Its\Library\Seo\OpenGraph;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

global $USER, $APPLICATION;
Loc::loadMessages(__FILE__);

$asset = AssetManager::getInstance();
$asset->showInnerAsset(\CSite::InGroup([1])); // 1 - Администраторы

$asset->addCss('/assets/css/index.css');
$asset->addJs('/assets/js/runtime.js')->defer();
$asset->addJs('/assets/js/index.js')->defer();
$asset->addJs(SITE_TEMPLATE_PATH . '/tool.js')->defer();

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <title><?php $APPLICATION->ShowTitle()?></title>
        <meta name="description" content="template">
        <meta name="keywords" content="template">
        <meta name="robots" content="noindex, nofollow">
        <link rel="manifest" href="/assets/favicon/manifest.webmanifest">
        <link rel="icon" href="/assets/favicon/favicon.ico" sizes="any">
        <link rel="icon" href="/assets/favicon/icon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/assets/favicon/apple-touch-icon.png">
        <?php
        $asset->showHead();
        OpenGraph::showMeta();
        ?>
    </head>

    <body>
    <?php
    if ($USER->IsAdmin()) {
        ?>
        <div id="bitrix-panel-wrap">
            <?php $APPLICATION->ShowPanel()?>
        </div>
        <?php
    }
    ?>
    <header class="header" data-header>
            <div class="header__inner container">
                <nav class="header__nav">
                    <button class="header__menu"
                            data-modal-url="/local/ajax/modal-mobile-menu.php"
                            data-modal-open="mobile-menu">
                        <span></span>
                        <span></span>
                    </button>
                    <ul class="header__nav-list">
                        <li>
                            <button class="header__nav-list-btn"
                                    data-modal-url="/local/ajax/modal-menu.php"
                                    data-modal-open="menu">
                                <p><?= Loc::getMessage('HEADER_LINK_MENU') ?></p>
                                <svg class="i-arrow-down">
                                    <use xlink:href="#arrow-down"></use>
                                </svg>
                            </button>
                        </li>
                        <li>
                            <button class="header__nav-list-btn"
                                    data-modal-url="/local/ajax/modal-learn-more.php"
                                    data-modal-open="learn-more">
                                <p><?= Loc::getMessage('HEADER_LINK_LEARN_MORE') ?></p>
                                <svg class="i-arrow-down">
                                    <use xlink:href="#arrow-down"></use>
                                </svg>
                            </button>
                        <li>
                            <a href="/doctors/"><?= Loc::getMessage('HEADER_LINK_DOCTORS') ?></a>
                        </li>
                    </ul>
                </nav>
                <div class="header__logo">
                    <a class="logo" href="/">
                        <svg width="318" height="47" viewBox="0 0 318 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2568_286)">
                                <path d="M31.7201 1.6843H19.7037L0.00012207 45.315H9.22445L14.394 33.7847H36.8916L41.9911 45.315H51.4236L31.7201 1.6843ZM17.6083 26.5537L25.6418 8.66536L33.6073 26.5537H17.6083Z" fill="#101010" />
                                <path d="M314.529 4.36431C314.459 3.42876 313.551 2.68066 312.434 2.68066H309.918V8.10305H310.967V6.23368H312.364L313.342 8.10305H314.529L313.41 6.04622C314.039 5.73379 314.529 5.11067 314.529 4.36257V4.36431ZM312.434 5.29986H310.967V3.61622H312.434C312.992 3.61622 313.412 3.99113 313.412 4.48928C313.412 4.92495 312.992 5.29986 312.434 5.29986Z" fill="#101010" />
                                <path d="M312.015 0.753418C309.151 0.753418 306.846 2.87273 306.846 5.42771C306.846 7.98268 309.151 10.102 312.015 10.102C314.879 10.102 317.325 7.98268 317.325 5.42771C317.325 2.87273 314.949 0.753418 312.015 0.753418ZM312.015 9.16818C309.71 9.16818 307.892 7.48453 307.892 5.42771C307.892 3.37088 309.71 1.68723 312.015 1.68723C314.321 1.68723 316.278 3.37088 316.278 5.42771C316.278 7.48453 314.391 9.16818 312.015 9.16818Z" fill="#101010" />
                                <path d="M89.1214 20.0702L79.1305 19.0114C73.4005 18.3883 70.5365 16.144 70.5365 13.2766C70.5365 10.1593 73.8908 7.85424 81.5061 7.85424C88.0746 7.85424 91.5671 10.0985 91.427 13.714L100.301 13.7765C100.371 5.61169 93.2442 0.5 81.5061 0.5C69.768 0.5 61.8025 5.61169 61.8025 13.7765C61.8025 19.947 66.5538 24.8087 74.3792 25.6818L86.4656 26.9905C91.2168 27.4887 93.5925 29.7955 93.5925 32.7253C93.5925 36.4658 89.3996 39.1458 81.5061 39.1458C74.3091 39.1458 68.9294 36.5908 68.8594 33.286H60.1253C60.0553 42.0739 70.6066 46.5 81.5042 46.5C91.2849 46.5 102.465 42.0114 102.465 32.2272C102.465 25.621 97.2951 20.945 89.1194 20.0737" fill="#101010" />
                                <path d="M294.896 1.68408H282.878L263.314 45.3148H272.537L277.636 33.8452H300.134L305.233 45.3131H314.666L294.896 1.68408ZM280.853 26.6159L288.888 8.66514L296.854 26.6159H280.854H280.853Z" fill="#101010" />
                                <path d="M127.164 26.6784H148.823V19.4492H127.164V9.10254H153.993V1.68408H118.57V45.3148H154.901V37.8981H127.164V26.6784Z" fill="#101010" />
                                <path d="M208.673 15.5214C208.463 7.7923 200.918 1.6843 192.254 1.6843H171.434V45.315H180.028V30.2317H192.604C201.478 30.2317 208.884 23.6863 208.673 15.5214ZM191.906 23.0007H180.028V9.10276H191.906C196.239 9.10276 199.801 12.2184 199.801 16.0838C199.801 19.9493 196.239 23.0024 191.906 23.0024V23.0007Z" fill="#101010" />
                                <path d="M234.702 45.3148H243.644V9.10254H259.715V1.68408H218.633V9.10254H234.702V45.3148Z" fill="#101010" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2568_286">
                                    <rect width="317.324" height="46" fill="white" transform="translate(0 0.5)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                </div>
                <div class="header__right">
                    <?php $APPLICATION->IncludeComponent(
                        'bitrix:main.include',
                        'phone',
                        [
                            'AREA_FILE_SHOW' => 'file',
                            'PATH' => SITE_TEMPLATE_PATH . '/include_area/' . SITE_ID . '/template_phone.php',
                        ],
                        true
                    );?>
                   <a href="/address/" class="btn btn--small btn--outline">
                       <span class="btn__text"><?= Loc::getMessage('HEADER_LINK_WHERE_TO_BUY') ?></span>
                    </a>
                    <button class="header__search">
                        <svg class="i-search">
                            <use xlink:href="#search"></use>
                        </svg>
                    </button>
                    <button class="header__close" data-modal-close="mobile-menu">
                        <svg class="i-cross">
                            <use xlink:href="#cross"></use>
                        </svg>
                    </button>
                    <a class="btn header__right-basket" href="/address/">
                        <svg class="i-cart">
                            <use xlink:href="#cart"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </header>
        <main>
            <div class="page" <?php $APPLICATION->ShowViewContent('PAGE_DATA_PAGE')?>>
