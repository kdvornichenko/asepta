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

<?php
if (!empty($arParams['~AUTH_RESULT']['MESSAGE'])) {
    $title = $arParams['~AUTH_RESULT']['TYPE'] !== 'ERROR'
        ? Loc::getMessage('FORGOT_FORM_SUCCESS')
        : Loc::getMessage('FORGOT_FORM_ERROR');
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
<div class="recovery-body container">
    <div class="recovery-body__inner">
        <h1><?php $APPLICATION->ShowTitle(false)?></h1>
        <form
            class="form__part personal__form"
            data-form="login"
            data-form-error="<?=Loc::getMessage('FORGOT_FORM_VALID_ERROR')?>"
            name="bform"
            method="post"
            target="_top"
            action="<?=$arResult['AUTH_URL']?>"
        >
            <p><?=Loc::getMessage('FORGOT_FORM_TITLE')?></p>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="SEND_PWD">
            <input type="hidden" name="USER_REMEMBER" value="N">
            <?php
            if (strlen($arResult['BACKURL']) > 0) {
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>">
                <?php
            }
            ?>
            <div class="form__input-wrapper personal__input-wrapper">

                <input
                    class="form__input validate"
                    type="email"
                    placeholder="<?=Loc::getMessage('FORGOT_FORM_EMAIL')?>"
                    data-mail-error="<?=Loc::getMessage('FORGOT_FORM_VALID_ERROR_EMAIL')?>"
                    name="USER_EMAIL"
                />
                <span class="form__error"></span>
            </div>
            <div class="personal__buttons-row">
                <button class="btn btn--fill" name="send_account_info" value="Y" type="submit" data-submit>
                        <span class="btn__text">
                            <?=Loc::getMessage('FORGOT_FORM_FORGOT')?>
                        </span>
                </button>
            </div>
        </form>
    </div>
</div>
