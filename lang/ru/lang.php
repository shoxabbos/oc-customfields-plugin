<?php return [
    'plugin' => [
        'name' => 'CustomFields',
        'description' => 'This plugin allows add custom fields to CMS page',
    ],
    'editor' => [
        'custom_fields_tab' => 'Custom fields',
    ],
    'property' => [
        'type' => 'Тип',
        'comment' => 'Комментарий',
        'default' => 'По умолчанию',
        'name' => 'Название свойства (Только на английском)',
        'label' => 'Название',
        'is_translatable' => 'Переводимое поле',
    ],
    'group' => [
        'is_repeater' => 'Повторяющий',
        'name' => 'Название вкладки',
        'page' => 'Страница',
        'properties' => 'Настраиваемые поля',
        'code' => 'Код',
        'updated_at' => 'Дата обновления',
        'created_at' => 'Дата создания',
        'position' => 'Позиция вкладки',
    ],
    'permession' => [
        'manage_properties' => 'Управление свойствами',
        'manage_groups' => 'Управление группами',
        'manager_cms_code_content' => 'Edit cms code content',
    ],
    'menu' => [
        'groups' => 'Группа полей',
    ],
];