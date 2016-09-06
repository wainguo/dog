<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Labels Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in labels throughout the system.
    | Regardless where it is placed, a label can be listed here so it is easily
    | found in a intuitive way.
    |
    */

    'general' => [
        'all' => '全部',
        'yes' => '是',
        'no' => '否',
        'custom' => 'Custom',
        'buttons' => [
            'save' => '保存',
            'update' => '确定更改',
        ],
        'hide' => 'Hide',
        'none' => 'None',
        'show' => 'Show',
        'toggle_navigation' => 'Toggle Navigation',
    ],

    'backend' => [
        'access' => [
            'roles' => [
                'create' => 'Create Role',
                'edit' => 'Edit Role',
                'management' => 'Role Management',

                'table' => [
                    'number_of_users' => 'Number of Users',
                    'permissions' => 'Permissions',
                    'role' => 'Role',
                    'sort' => 'Sort',
                    'total' => 'role total|roles total',
                ],
            ],

            'users' => [
                'active' => 'Active Users',
                'all_permissions' => 'All Permissions',
                'change_password' => 'Change Password',
                'change_password_for' => 'Change Password for :user',
                'create' => 'Create User',
                'deactivated' => 'Deactivated Users',
                'deleted' => 'Deleted Users',
                'edit' => 'Edit User',
                'management' => 'User Management',
                'no_permissions' => 'No Permissions',
                'no_roles' => 'No Roles to set.',
                'permissions' => 'Permissions',

                'table' => [
                    'confirmed' => 'Confirmed',
                    'created' => 'Created',
                    'email' => 'E-mail',
                    'id' => 'ID',
                    'last_updated' => 'Last Updated',
                    'name' => 'Name',
                    'no_deactivated' => 'No Deactivated Users',
                    'no_deleted' => 'No Deleted Users',
                    'roles' => 'Roles',
                    'total' => 'user total|users total',
                ],
            ],
        ],
    ],

    'frontend' => [

        'auth' => [
            'login_box_title' => '登录',
            'login_button' => '登录',
            'login_with' => 'Login with :social_media',
            'register_box_title' => '注册',
            'register_button' => '注册',
            'remember_me' => '30天内免登陆',
        ],

        'passwords' => [
            'forgot_password' => '忘记密码?',
            'reset_password_box_title' => '重置密码',
            'reset_password_button' => '重置密码',
            'send_password_reset_link_button' => '发送重置密码链接',
        ],

        'user' => [
            'passwords' => [
                'change' => '更改密码',
            ],

            'profile' => [
                'avatar' => '头像',
                'created_at' => '注册于',
                'edit_information' => '编辑个人信息',
                'email' => 'E-mail邮箱',
                'last_updated' => '最后更新',
                'name' => '昵称',
                'update_information' => '更新个人信息',
            ],
        ],

    ],
];
