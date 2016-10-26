<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menus Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in menu items throughout the system.
    | Regardless where it is placed, a menu item can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'backend' => [
        'access' => [
            'title' => '访问权限管理',

            'roles' => [
                'all' => '全部角色',
                'create' => '创建角色(Role)',
                'edit' => '编辑角色',
                'management' => '角色管理',
                'main' => '角色',
            ],

            'users' => [
                'all' => '全部用户',
                'change-password' => '更改密码',
                'create' => '创建用户(User)',
                'deactivated' => '冻结用户',
                'deleted' => '删除用户',
                'edit' => '编辑用户',
                'main' => '用户',
            ],
        ],

        'slider' => [
            'management' => '幻灯管理',
        ],

        'log-viewer' => [
            'main' => '日志查看',
            'dashboard' => '仪表盘',
            'logs' => '日志',
        ],

        'sidebar' => [
            'dashboard' => '管理首页',
            'general' => 'General',
        ],
    ],

    'language-picker' => [
        'language' => 'Language',
        /**
         * Add the new language to this array.
         * The key should have the same language code as the folder name.
         * The string should be: 'Language-name-in-your-own-language (Language-name-in-English)'.
         * Be sure to add the new language in alphabetical order.
         */
        'langs' => [
            'ar' => 'Arabic',
            'da' => 'Danish',
            'de' => 'German',
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'it' => 'Italian',
            'pt-BR' => 'Brazilian Portuguese',
            'sv' => 'Swedish',
            'th' => 'Thai',
        ],
    ],
];
