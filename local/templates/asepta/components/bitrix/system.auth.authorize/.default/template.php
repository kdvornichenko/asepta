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

$this->setFrameMode(false);

?>
<div class="page__inner register-page__inner">
    <div class="login-body container">
        <h1><?php $APPLICATION->ShowTitle(false)?></h1>
        <div class="register-banner">
            <div class="register-banner__top">
                <?=Loc::getMessage('AUTH_FORM_SUBTITLE')?>
            </div>
            <div class="register-banner__image">
                <picture>
                    <source type="image/webp" srcset="/assets/img/webp/magnifier.webp" media="">
                    <source type="image/jpeg" srcset="/assets/img/magnifier.jpg" media="(min-width: 1024px)">
                    <img src="/assets/img/magnifier.jpg" alt="">
                </picture>
            </div>
            <div class="register-banner__bottom">
                <p><?=Loc::getMessage('AUTH_FORM_REGISTER_TITLE')?></p>
                <a class="btn btn--outline" href="<?=$arResult['AUTH_REGISTER_URL']?>">
                        <span class="btn__text">
                            <?=Loc::getMessage('AUTH_FORM_REGISTER')?>
                        </span>
                </a>
            </div>
        </div>
    <?php
    if (!empty($arParams['~AUTH_RESULT']['MESSAGE'])) {
        $title = $arParams['~AUTH_RESULT']['TYPE'] !== 'ERROR'
            ? Loc::getMessage('AUTH_FORM_SUCCESS')
            : Loc::getMessage('AUTH_FORM_ERROR');
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                renderMessageModal(
                    <?=json_encode($title)?>,
                    <?=json_encode($arParams['~AUTH_RESULT']['MESSAGE'])?>
                );
            });
        </script>
        <?php
    }
    ?>
            <form
                class="login-body__form"
                data-form="login"
                data-form-error="<?=Loc::getMessage('AUTH_FORM_VALID_ERROR')?>"
                name="form_auth"
                method="post"
                target="_top"
                action="<?=$arResult['AUTH_URL']?>"
            >
                <fieldset class="login-body__form-item">
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="AUTH">
                    <?php
                    if (strlen($arResult['BACKURL']) > 0) {
                        ?>
                        <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>">
                        <?php
                    }
                    foreach ($arResult['POST'] as $key => $value) {
                        ?>
                        <input type="hidden" name="<?=$key?>" value="<?=$value?>">
                        <?php
                    }
                    if ($arResult['STORE_PASSWORD'] === 'Y') {
                        ?>
                        <input type="hidden" name="USER_REMEMBER" value="Y">
                        <?php
                    }
                    ?>
                    <div class="form__input-wrapper">
                        <label class="form__label">
                            <?=Loc::getMessage('AUTH_FORM_EMAIL')?>
                        </label>
                        <input
                            class="form__input validate"
                            type="email"
                            placeholder="ivan@mail.ru"
                            data-mail-error="<?=Loc::getMessage('AUTH_FORM_VALID_ERROR_EMAIL')?>"
                            name="USER_LOGIN"
                            value="<?=htmlspecialchars((string)$_REQUEST['USER_LOGIN'])?>"
                        />
                        <span class="form__error"></span>
                    </div>
                    <div class="form__input-wrapper">
                        <label class="form__label">
                            <?=Loc::getMessage('AUTH_FORM_PASS')?>
                        </label>
                        <input
                            class="form__input validate"
                            type="password"
                            placeholder="********"
                            name="USER_PASSWORD"
                        />
                        <span class="form__error"></span>
                    </div>
                    <a href="<?=$arResult['AUTH_FORGOT_PASSWORD_URL']?>">
                        <?=Loc::getMessage('AUTH_FORM_FORGOT')?>
                    </a>
                </fieldset>
                    <button class="btn btn--fill" name="Login" value="Y" type="submit" data-submit>
                        <span class="btn__text">
                            <?=Loc::getMessage('AUTH_FORM_AUTH')?>
                        </span>
                    </button>
                <p class="personal__checkbox form__confirm">
                    <?=Loc::getMessage('AUTH_FORM_POLITIC', ['#LINK#' => PRIVACY_POLICY_URL])?>
                </p>
            </form>
        </div>
    </div>
