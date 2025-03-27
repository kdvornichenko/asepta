<?php
use Bitrix\Main\SiteTable;

$map = [
    'directory' => 'include_area',
    'groups' => [
        'template' => [
            'name' => 'Шаблон сайта',
            'files' => [
                [
                    'name' => 'Телефон',
                    'path' =>  'template_phone.php',
                    'type' => 'string',
                ],
                [
                    'name' => 'Почта',
                    'path' =>  'template_email.php',
                    'type' => 'string',
                ],
                [
                    'name' => 'Текст в футере',
                    'path' =>  'template_footer_text.php',
                    'type' => 'lines',
                    'lines' => [
                        'Заголовок',
                        'Текст',
                    ],
                ],

            ],

        ],
        'menu' => [
            'name' => 'Верхнее меню',
            'files' => [
                [
                    'name' => 'Узнать больше',
                    'path' =>  'menu_brands_info.php',
                    'type' => 'lines',
                    'lines' => [
                        'Заголовок',
                        'Название кнопки',
                        'Ссылка',
                        'Изображение',
                        'Изображение (мобильное)',
                    ],
                    'types' => [
                        'string',
                        'string',
                        'string',
                        'image',
                        'image',
                        ]
                ],
                [
                    'name' => 'Продукция (смотреть все)',
                    'path' =>  'menu_products_link.php',
                    'type' => 'lines',
                    'lines' => [
                        'Название кнопки',
                        'Ссылка',
                    ],
                    'types' => [
                        'string',
                        'string',
                    ]
                ],

            ],

        ],
        'main' => [
            'name' => 'Главная',
            'files' => [
                [
                    'name' => 'Где купить',
                    'path' =>  'main_where_to_buy.php',
                    'type' => 'lines',
                    'lines' => [
                        'Заголовок блока',
                        'Ссылка',
                        'Изображение (выезжающее)',
                        'Фоновое изображение',
                        'Цвет фона',
                        'Цвет заголовка'
                    ],
                    'types' => [
                        'string',
                        'string',
                        'image',
                        'image',
                        'color',
                        'color'
                    ],
                ],
                [
                    'name' => 'Врачам',
                    'path' =>  'main_doctors.php',
                    'type' => 'lines',
                    'lines' => [
                        'Заголовок блока',
                        'Ссылка',
                        'Изображение',
                        'Фоновое изображение',
                        'Цвет фона',
                        'Цвет заголовка'
                    ],
                    'types' => [
                        'string',
                        'string',
                        'image',
                        'image',
                        'color',
                        'color'
                    ],
                ],
            ],
        ],
        'catalog' => [
            'name' => 'Каталог',
            'files' => [
                [
                    'name' => 'Иконка для преимуществ',
                    'path' =>  'catalog_detail_advantages_icon.php',
                    'type' => 'file',
                ],
            ],

        ],
    ],
];

$sites = [];
$sitesResource = SiteTable::getList([
    'order' => ['SORT' => 'ASC'],
    'select' => ['LID', 'NAME'],
]);
while ($siteData = $sitesResource->fetch()) {
    $sites[$siteData['LID']] = $siteData['NAME'];
}

$groupIndex = 0;
foreach ($map['groups'] as $groupId => $group) {
    foreach ($sites as $siteId => $siteName) {
        $groupIndex++;
        $langGroupId = "{$groupId}_{$siteId}";
        $map['groups'][$langGroupId] = [
            'sort' => $groupIndex * 100,
            'name' => "{$group['name']} ({$siteName})",
        ];
        $fileIndex = 0;
        if (count($group['files'])) {
            $step = intval(1000 / count($group['files']));
            foreach ($group['files'] as $file) {
                $fileIndex++;
                $file['sort'] = ($groupIndex * 1000) + ($fileIndex * $step);
                $file['group'] = $langGroupId;
                $file['path'] = "{$siteId}/{$file['path']}";
                $content = file_get_contents(__DIR__ . '/include_default/' . $file['path']);
                if (!in_array($file['type'], ['image', 'lines'])) {
                    $content = htmlspecialchars($content);
                }
                $file['default'] = "<pre style='max-width: 1200px; overflow: auto; padding: 15px'>{$content}</pre>";
                $map['files'][] = $file;
            }
        }
    }
    unset($map['groups'][$groupId]);
}

return $map;
