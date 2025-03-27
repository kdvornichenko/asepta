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

$this->setFrameMode(true);

if (empty($arResult)) {
    return;
}

$menuTree = ['ITEMS' => []];
$previous = [0 => &$menuTree['ITEMS']];
foreach ($arResult as $arItem) {
    $level = intval($arItem['DEPTH_LEVEL']);
    $arItem['ITEMS'] = [];
    $previous[$level - 1][] = $arItem;
    $previous[$level] = &$previous[$level - 1][count($previous[$level - 1]) - 1]['ITEMS'];
}
unset($arResult, $previous);

?>

<nav class="header__nav">
    <button class="header__menu"><span></span><span></span>
    </button>
    <ul class="header__nav-list">
        <?php
        foreach ($menuTree['ITEMS'] as $itemData) {
            if ($itemData['PERMISSION'] <= 'D') {
                continue;
            }
            ?>
            <li <?=(!empty($itemData['ITEMS']) ? 'data-acc' : '')?>>
            <?php
            $test = strpos($_SERVER['REQUEST_URI'], $itemData['LINK']);
            if(!empty($itemData['ITEMS'])){
            ?>
                <button class="header__nav-list-btn <?= strpos($_SERVER['REQUEST_URI'], $itemData['LINK']) !== false ? 'is_active' : '' ?>">
                    <p> <?=$itemData['TEXT']?></p>
                    <svg class="i-arrow-down">
                        <use xlink:href="#arrow-down"></use>
                    </svg>
                </button>
               <?php
                } else {
                ?>
                <a class="<?= strpos($_SERVER['REQUEST_URI'], $itemData['LINK']) !== false ? 'is_active' : '' ?>" href="<?=htmlspecialchars($itemData['LINK'])?>">
                    <?=$itemData['TEXT']?>
                </a>
                <?php
                }
                if (!empty($itemData['ITEMS'])) {
                    ?>
                    <div class="header__nav-list-inner" data-acc-content="more">
                        <ul data-acc-content-inner>
                            <?php
                            foreach ($itemData['ITEMS'] as $subItemData) {
                                if ($itemData['PERMISSION'] <= 'D') {
                                    continue;
                                }
                                ?>
                                <a href="<?=htmlspecialchars($subItemData['LINK'])?>">
                                    <?=$subItemData['TEXT']?>
                                </a>
                                <?php
                                }
                                ?>
                       </ul>
                    </div>
                    <?php
                }?>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
