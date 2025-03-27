<?php

use Bitrix\Main\Localization\Loc;
use Its\Library\Asset\AssetManager;

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

if ($USER->IsAuthorized()) {
    return;
}

?>
<div class="page__inner register-page__inner">
    <div class="register-body container">
        <h1><?php $APPLICATION->ShowTitle(false)?></h1>
        <div class="register-banner">
            <div class="register-banner__top">
                <?=Loc::getMessage('REGISTER_SUBTITLE')?>
            </div>
            <div class="register-banner__image">
                <picture>
                    <source type="image/webp" srcset="/assets/img/webp/magnifier.webp" media="">
                    <source type="image/jpeg" srcset="/assets/img/magnifier.jpg" media="(min-width: 1024px)">
                    <img src="/assets/img/magnifier.jpg" alt="">
                </picture>
            </div>
            <div class="register-banner__bottom">
                <p> <?=Loc::getMessage('REGISTER_AUTH_TITLE')?></p>
                <a class="btn btn--outline" href="<?=$arParams['AUTH_LINK']?>">
                    <span class="btn__text">
                        <?=Loc::getMessage('REGISTER_AUTH')?>
                    </span>
                </a>
            </div>
        </div>
        <div class="block personal__block">
            <?php
            if (count($arResult['ERRORS']) > 0) {
                array_walk($arResult['ERRORS'], function (&$message, $key) {
                    if (intval($key) == 0 && $key !== 0) {
                        $message = str_replace(
                            '#FIELD_NAME#',
                            '&quot;' . Loc::getMessage('REGISTER_FIELD_' . $key) . '&quot;',
                            $message
                        );
                    }
                });
                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        renderMessageModal(
                            <?=json_encode(Loc::getMessage('REGISTER_ERROR'))?>,
                            <?=json_encode(implode('<br>', $arResult['ERRORS']))?>
                        );
                    });
                </script>
                <?php
            }
            ?>
            <form
                id="registerForm"
                class="register-body__form"
                data-form="login"
                data-form-error="<?=Loc::getMessage('REGISTER_FIELD_ERROR')?>"
                method="post"
                action="<?=POST_FORM_ACTION_URI?>"
                name="regform"
                enctype="multipart/form-data"
            >
                <?php
                if ($arResult['BACKURL']) {
                    ?>
                    <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>">
                    <?php
                }

                echo bitrix_sessid_post();

                // Фейковый инпут для отлова роботов
                ?>
                <input class="register-birthday-ex" type="text" name="REGISTER_BIRTHDAY_EX" value="">
                <style>
                    .register-birthday-ex {
                        opacity: 0;
                        width: 1px;
                        height: 1px;
                    }
                </style>
                <fieldset class="register-body__form-part">
                <?php
                foreach ($arResult['SHOW_FIELDS'] as $code) {
                    $name = Loc::getMessage("REGISTER_FIELD_{$code}");
                    $isRequired = in_array($code, $arResult['REQUIRED_FIELDS']);
                    ?>
                    <?php
                    switch ($code) {
                        case 'LOGIN':
                            break;

                        case 'EMAIL':
                            ?>
                            <div class="form__input-wrapper">
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="email"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="ivan@mail.ru"
                                    data-mail-error="<?=Loc::getMessage('REGISTER_FIELD_ERROR_EMAIL')?>"
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;

                        case 'PHONE_NUMBER':
                            ?>
                            <div class="form__tel-wrapper">
                                <div class="select select--checked select--common" data-select="reg_tel">
                                    <button class="select__btn" type="button"><span class="select__btn-text">+7</span>
                                        <svg class="i-arrow-down">
                                            <use xlink:href="#arrow-down"></use>
                                        </svg>
                                    </button>
                                    <div class="select__content">
                                        <div class="select__content-inner">
                                            <div class="select__option">
                                                <input type="radio" data-name="+7" name="reg_tel" value="+7" id="tel_1" checked="checked">
                                                <label for="tel_1">+7</label>
                                            </div>
                                            <div class="select__option">
                                                <input type="radio" data-name="+375" name="reg_tel" value="+375" id="tel_2">
                                                <label for="tel_2">+375</label>
                                            </div>
                                            <div class="select__option">
                                                <input type="radio" data-name="+998" name="reg_tel" value="+998" id="tel_3">
                                                <label for="tel_3">+998</label>
                                            </div>
                                            <div class="select__option">
                                                <input type="radio" data-name="+996" name="reg_tel" value="+996" id="tel_4">
                                                <label for="tel_4">+996</label>
                                            </div>
                                            <div class="select__option">
                                                <input type="radio" data-name="+992" name="reg_tel" value="+992" id="tel_5">
                                                <label for="tel_5">+992</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="tel"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="<?=Loc::getMessage('REGISTER_FIELD_PHONE_NUMBER')?>"
                                    data-tel
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;

                        case 'PASSWORD':
                        case 'CONFIRM_PASSWORD':
                            ?>
                            <div class="form__input-wrapper">
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="password"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="********"
                                    autocomplete="new-password"
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;

                        case 'NAME':
                            ?>
                            <div class="form__input-wrapper">
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="text"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="<?=Loc::getMessage('REGISTER_PLACEHOLDER_NAME')?>"
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;

                        case 'PERSONAL_CITY':
                            ?>
                            <div class="form__input-wrapper">
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="text"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="<?=Loc::getMessage('REGISTER_FIELD_PERSONAL_CITY')?>"
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;
                        case 'UF_SPECIALIZATION':
                            ?>
                            <div class="form__input-wrapper">
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="text"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="<?=Loc::getMessage('REGISTER_FIELD_UF_SPECIALIZATION')?>"
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;
                        case 'WORK_POSITION':
                            ?>
                            <div class="form__input-wrapper">
                                <input
                                    class="form__input <?=($isRequired ? 'validate' : '')?>"
                                    type="text"
                                    name="REGISTER[<?=$code?>]"
                                    value="<?=$arResult['VALUES'][$code]?>"
                                    placeholder="<?=Loc::getMessage('REGISTER_FIELD_WORK_POSITION')?>"
                                />
                                <span class="form__error"></span>
                            </div>
                            <?php
                            break;
                    }
                    ?>
                    <?php
                }
                ?>
                </fieldset>
                <fieldset class="register-body__final">
                    <div class="form__checbox-wrapper">
                        <div class="form__checbox">
                            <input type="checkbox" id="reg">
                            <label for="reg">
                                <svg class="i-check">
                                    <use xlink:href="#check"></use>
                                </svg>
                            </label>
                        </div>
                        <label for="reg">
                            <?=Loc::getMessage('REGISTER_CONFIRM')?>
                        </label>
                    </div>
                        <button class="btn btn--fill"
                                type="submit"
                                data-submit
                                name="register_submit_button"
                                value="Y">
                            <span class="btn__text">
                                <?=Loc::getMessage('REGISTER_SEND')?>
                            </span>
                        </button>
                </fieldset>
                <div class="register-body__policy">
                    <svg class="i-info">
                        <use xlink:href="#info"></use>
                    </svg>
                    <p> <?=Loc::getMessage('REGISTER_POLITIC', ['#LINK#' => PRIVACY_POLICY_URL])?></p>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if ($arParams['USE_CAPTCHA'] === 'Y') {
    AssetManager::getInstance()->addJs("https://www.google.com/recaptcha/api.js?render={$arParams['CAPTCHA_PUBLIC']}");
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            grecaptcha.ready(() => {
                grecaptcha.execute(<?=json_encode($arParams['CAPTCHA_PUBLIC'])?>, {action: 'submit'}).then(token => {
                    let input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'g-recaptcha-response');
                    input.value = token;
                    document.getElementById('registerForm').insertAdjacentElement('afterbegin', input);
                });
            });
        });
    </script>
    <?php
}
?>
